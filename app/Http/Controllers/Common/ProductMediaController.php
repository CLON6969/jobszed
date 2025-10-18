<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductMediaController extends Controller
{
    /**
     * Display a listing of media items.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id !== 3) {
            abort(403, 'Unauthorized');
        }

        $media = ProductMedia::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('product')->latest()->paginate(12);

        return view('user.Seller.product_media.index', compact('media'));
    }

    /**
     * Show the form for uploading new media.
     */
    public function create()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        return view('user.Seller.product_media.create', compact('products'));
    }

    /**
     * Store a newly uploaded media item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'media' => 'required|file|mimes:jpg,jpeg,png,webp,mp4|max:10240', // up to 10MB
        ]);

        $path = $request->file('media')->store('product_media', 'public');

        ProductMedia::create([
            'product_id' => $request->product_id,
            'file_path' => $path,
            'file_type' => $request->file('media')->getClientOriginalExtension(),
        ]);

        return redirect()->route('user.Seller.product-media.index')
            ->with('success', 'Media uploaded successfully.');
    }

    /**
     * Show details for a specific media item.
     */
    public function show(ProductMedia $productMedia)
    {
        $this->authorizeAccess($productMedia);
        return view('user.Seller.product_media.show', compact('productMedia'));
    }

    /**
     * Edit media details.
     */
    public function edit(ProductMedia $productMedia)
    {
        $this->authorizeAccess($productMedia);
        $products = Product::where('user_id', Auth::id())->get();
        return view('user.Seller.product_media.edit', compact('productMedia', 'products'));
    }

    /**
     * Update media info.
     */
    public function update(Request $request, ProductMedia $productMedia)
    {
        $this->authorizeAccess($productMedia);

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productMedia->update([
            'product_id' => $request->product_id,
        ]);

        return redirect()->route('user.Seller.product-media.index')
            ->with('success', 'Media updated successfully.');
    }

    /**
     * Remove media from storage.
     */
    public function destroy(ProductMedia $productMedia)
    {
        $this->authorizeAccess($productMedia);
        Storage::disk('public')->delete($productMedia->file_path);
        $productMedia->delete();

        return redirect()->route('user.Seller.product-media.index')
            ->with('success', 'Media deleted successfully.');
    }

    /**
     * Check if user can access the media.
     */
    private function authorizeAccess(ProductMedia $productMedia)
    {
        if ($productMedia->product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    }
}
