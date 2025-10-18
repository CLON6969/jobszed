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
use Illuminate\Support\Facades\Storage;

class ProductCreationController extends Controller
{
    /**
     * Show form for adding a new product (with media & variations)
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('Seller.products.create-full', compact('categories'));
    }

    /**
     * Store a new product with media and variations.
     */
    public function store(Request $request)
    {
        $seller = Auth::user();

        if ($seller->role_id !== 3) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:50',
            'stock_quantity' => 'required|integer|min:0',
            'delivery_available' => 'required|boolean',
            'location' => 'nullable|string|max:255',

            // Media
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,mp4,avi,mov|max:10240',

            // Variations (optional)
            'variations.*.name' => 'nullable|string|max:100',
            'variations.*.option' => 'nullable|string|max:100',
            'variations.*.price_adjustment' => 'nullable|numeric',
            'variations.*.stock' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create product
            $product = Product::create([
                'seller_id' => $seller->id,
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '',
                'price' => $validated['price'],
                'condition' => $validated['condition'],
                'stock_quantity' => $validated['stock_quantity'],
                'status' => 'active',
                'delivery_available' => $validated['delivery_available'],
                'location' => $validated['location'] ?? '',
            ]);

            // Upload Media (if provided)
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $index => $file) {
                    $path = $file->store('product_media', 'public');
                    $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';

                    ProductMedia::create([
                        'product_id' => $product->id,
                        'file_path' => $path,
                        'media_type' => $type,
                        'is_primary' => $index === 0, // first one is primary
                    ]);
                }
            }

            // Add Variations (optional)
            if ($request->filled('variations')) {
                foreach ($request->variations as $var) {
                    if (!empty($var['name'])) {
                        ProductVariation::create([
                            'product_id' => $product->id,
                            'name' => $var['name'],
                            'option' => $var['option'] ?? '',
                            'price_adjustment' => $var['price_adjustment'] ?? 0,
                            'stock' => $var['stock'] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('seller.products.index')
                ->with('success', 'Product created successfully with media and variations.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Error: ' . $e->getMessage()])
                         ->withInput();
        }
    }
}
