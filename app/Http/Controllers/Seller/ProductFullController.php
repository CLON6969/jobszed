<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductVariation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductFullController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::user();

        $query = Product::where('seller_id', $seller->id)
            ->with(['category', 'media', 'variations']);

        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('condition')) $query->where('condition', $request->condition);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('min_price')) $query->where('price', '>=', $request->min_price);
        if ($request->filled('max_price')) $query->where('price', '<=', $request->max_price);

        $products = $query->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('Seller.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('Seller.products.create-full', compact('categories'));
    }

  public function store(Request $request)
{
    $seller = Auth::user();
    if ($seller->role_id !== 3) abort(403, 'Unauthorized');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'condition' => 'required|string|max:50',
        'delivery_available' => 'required|boolean',
        'location' => 'nullable|string|max:255',
        'media.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4,avi,mov|max:10240',
        'variations.*.name' => 'nullable|string|max:100',
        'variations.*.option' => 'nullable|string|max:100',
        'variations.*.price_adjustment' => 'nullable|numeric',
        'variations.*.stock' => 'nullable|integer|min:0',
    ]);

    // DUPLICATE CHECK
    $existingProduct = Product::where('seller_id', $seller->id)
        ->where('name', $validated['name'])
        ->where('category_id', $validated['category_id'])
        ->first();

    if ($existingProduct) {
        return back()
            ->withInput()
            ->with('error', 'A product with this name and category already exists.');
    }

    DB::beginTransaction();
    try {
        // Calculate stock from variations
        $totalStock = collect($request->variations ?? [])
            ->sum(fn($v) => (int) ($v['stock'] ?? 0));

        // Create product
        $product = Product::create([
            'seller_id' => $seller->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'condition' => $validated['condition'],
            'stock_quantity' => $totalStock,
            'status' => 'active',
            'delivery_available' => $validated['delivery_available'],
            'location' => $validated['location'] ?? '',
        ]);

        // Upload media
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $path = $file->store('product_media', 'public');
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                ProductMedia::create([
                    'product_id' => $product->id,
                    'file_path' => $path,
                    'media_type' => $type,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        // Create variations
        if ($request->filled('variations')) {
            foreach ($request->variations as $var) {
                if (!empty($var['name'])) {
                    ProductVariation::create([
                        'product_id' => $product->id,
                        'name' => $var['name'],
                        'option' => $var['option'] ?? '',
                        'price_adjustment' => $var['price_adjustment'] ?? 0,
                        'stock' => (int) ($var['stock'] ?? 0),
                    ]);
                }
            }
        }

        DB::commit();
        return redirect()->route('Seller.products.index')
            ->with('success', 'Product created successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Product store error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
    }
}

    public function show($id)
    {
        $seller = Auth::user();
        $product = Product::where('seller_id', $seller->id)
            ->with(['category', 'media', 'variations'])
            ->findOrFail($id);

        return view('Seller.products.show-full', compact('product'));
    }

    public function edit($id)
    {
        $seller = Auth::user();
        $product = Product::where('seller_id', $seller->id)
            ->with(['media', 'variations'])
            ->findOrFail($id);

        $categories = Category::orderBy('name')->get();
        return view('Seller.products.edit-full', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $seller = Auth::user();
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:50',
            'delivery_available' => 'required|boolean',
            'location' => 'nullable|string|max:255',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4,avi,mov|max:10240',
            'variations.*.name' => 'nullable|string|max:100',
            'variations.*.option' => 'nullable|string|max:100',
            'variations.*.price_adjustment' => 'nullable|numeric',
            'variations.*.stock' => 'nullable|integer|min:0',
            'remove_media' => 'nullable|array',
            'remove_media.*' => 'integer|exists:product_media,id',
            'primary_existing' => 'nullable|integer',
            'primary_new' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // Update product
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'condition' => $validated['condition'],
                'delivery_available' => $validated['delivery_available'],
                'location' => $validated['location'] ?? '',
            ]);

            // Remove old media
            if ($request->filled('remove_media')) {
                $mediaToRemove = ProductMedia::whereIn('id', $request->remove_media)
                    ->where('product_id', $product->id)->get();

                foreach ($mediaToRemove as $media) {
                    if (Storage::disk('public')->exists($media->file_path)) {
                        Storage::disk('public')->delete($media->file_path);
                    }
                    $media->delete();
                }
            }

            // Upload new media
            $newMediaIds = [];
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $index => $file) {
                    $path = $file->store('product_media', 'public');
                    $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';
                    $media = ProductMedia::create([
                        'product_id' => $product->id,
                        'file_path' => $path,
                        'media_type' => $type,
                        'is_primary' => false,
                    ]);
                    $newMediaIds[$index] = $media->id;
                }
            }

            // Set primary media
            ProductMedia::where('product_id', $product->id)->update(['is_primary' => false]);
            if ($request->filled('primary_existing')) {
                ProductMedia::where('id', $request->primary_existing)
                    ->where('product_id', $product->id)
                    ->update(['is_primary' => true]);
            } elseif ($request->filled('primary_new')) {
                $newIndex = $request->primary_new;
                if (isset($newMediaIds[$newIndex])) {
                    ProductMedia::where('id', $newMediaIds[$newIndex])->update(['is_primary' => true]);
                }
            }

            // Delete old variations and create new ones
            $product->variations()->delete();
            $totalStock = 0;
            if ($request->filled('variations')) {
                foreach ($request->variations as $var) {
                    if (!empty($var['name'])) {
                        $variation = ProductVariation::create([
                            'product_id' => $product->id,
                            'name' => $var['name'],
                            'option' => $var['option'] ?? '',
                            'price_adjustment' => $var['price_adjustment'] ?? 0,
                            'stock' => (int) ($var['stock'] ?? 0),
                        ]);
                        $totalStock += $variation->stock;
                    }
                }
            }

            // Update total stock
            $product->stock_quantity = max(0, $totalStock);
            $product->save();

            DB::commit();
            return redirect()->route('Seller.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function quickUpdate(Request $request, $id)
    {
        $product = Auth::user()->products()->findOrFail($id);

        $request->validate([
            'status' => 'nullable|string|in:available,sold,out_of_stock,draft',
        ]);

        if ($request->filled('status')) {
            $product->status = $request->status;

            if ($request->status === 'sold') {
                $product->variations()->update(['stock' => 0]);
                $product->stock_quantity = 0;
            } else {
                $product->stock_quantity = $product->variations()->sum('stock');
            }
        }

        $product->save();
        return back()->with('success', 'Product updated successfully.');
    }

    public function deleteMedia($mediaId)
    {
        $seller = Auth::user();
        $media = ProductMedia::where('id', $mediaId)
            ->whereHas('product', fn($q) => $q->where('seller_id', $seller->id))
            ->firstOrFail();

        try {
            if (Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Media delete error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting media.']);
        }
    }

    public function destroy($id)
    {
        $seller = Auth::user();
        $product = Product::where('seller_id', $seller->id)->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($product->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }

            $product->variations()->delete();
            $product->delete();

            DB::commit();
            return redirect()->route('Seller.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
}
