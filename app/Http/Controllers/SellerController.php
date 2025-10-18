<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductVariation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    // List seller's products
    public function products()
    {
        $products = Auth::user()->products()->with(['variations', 'media'])->paginate(12);
        return response()->json($products);
    }

    // Create a product
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'delivery_available' => 'boolean',
            'location' => 'nullable|string',
        ]);

        $product = Auth::user()->products()->create($request->all());
        return response()->json(['message' => 'Product created', 'product' => $product]);
    }

    // Add product variation
    public function addVariation(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string',
            'option' => 'required|string',
            'price_adjustment' => 'numeric|min:0',
            'stock' => 'integer|min:0',
        ]);

        $variation = $product->variations()->create($request->all());
        return response()->json(['message' => 'Variation added', 'variation' => $variation]);
    }

    // Upload media
    public function addMedia(Request $request, Product $product)
    {
        $request->validate(['file_path' => 'required|string', 'media_type' => 'string']);

        $media = $product->media()->create($request->all());
        return response()->json(['message' => 'Media added', 'media' => $media]);
    }

    // View orders
    public function orders()
    {
        $orders = Order::where('seller_id', Auth::id())->with('items.product')->paginate(12);
        return response()->json($orders);
    }

    // View analytics (basic counts)
    public function analytics()
    {
        $productsCount = Auth::user()->products()->count();
        $ordersCount = Order::where('seller_id', Auth::id())->count();
        return response()->json(compact('productsCount', 'ordersCount'));
    }
}
