<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductMedia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductMediaController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();

        $products = Product::with(['media' => function($q) {
            $q->where('is_primary', true);
        }])
        ->where('seller_id', $sellerId)
        ->latest()
        ->paginate(20);

        return view('Seller.product-media.index', compact('products'));
    }

    public function create()
    {
        $sellerProducts = Product::where('seller_id', Auth::id())->get();
        return view('Seller.product-media.create', compact('sellerProducts'));
    }

   public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'media.*' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,gif',
        'primary_new' => 'nullable|integer',
    ]);

    $product = Product::where('id', $request->product_id)
        ->where('seller_id', Auth::id())
        ->firstOrFail();

    $primaryIndex = $request->primary_new;

    foreach ($request->file('media', []) as $index => $file) {
        $filePath = $file->store('product-media', 'public');

        ProductMedia::create([
            'product_id' => $product->id,
            'file_path' => $filePath,
            'media_type' => str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image',
            'is_primary' => ($primaryIndex !== null && $primaryIndex == $index),
        ]);
    }

    return redirect()->route('Seller.product-media.index')
        ->with('success', 'Media uploaded successfully.');
}

    public function show($id)
    {
        $product = Product::with('media')
            ->where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        return view('Seller.product-media.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('media')
            ->where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        return view('Seller.product-media.edit', compact('product'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,gif',
        'remove_media' => 'nullable|array',
        'primary_existing' => 'nullable|integer',
        'primary_new' => 'nullable|integer',
    ]);

    $product = Product::with('media')->where('id', $id)
        ->where('seller_id', Auth::id())->firstOrFail();

    // Delete selected existing media
    if ($request->remove_media) {
        foreach ($request->remove_media as $mediaId) {
            $media = ProductMedia::find($mediaId);
            if ($media) {
                if (Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }
        }
    }

    // Reset primary for all existing media
    foreach ($product->media as $media) {
        $media->is_primary = ($media->id == $request->primary_existing);
        $media->save();
    }

    // Upload new media
    $primaryIndex = $request->primary_new;
    foreach ($request->file('media', []) as $index => $file) {
    $filePath = $file->store('product-media', 'public');
    ProductMedia::create([
        'product_id' => $product->id,
        'file_path' => $filePath,
        'media_type' => str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image',
        'is_primary' => ($primaryIndex !== null && $primaryIndex == $index),
    ]);
}


    return redirect()->route('Seller.product-media.index')
        ->with('success', 'Product media updated successfully.');
}


    public function destroy($id)
    {
        $media = ProductMedia::where('id', $id)
            ->whereHas('product', fn($q) => $q->where('seller_id', Auth::id()))
            ->firstOrFail();

        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->route('Seller.product-media.index')
            ->with('success', 'Media deleted successfully.');
    }
}
