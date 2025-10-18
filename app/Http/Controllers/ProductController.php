<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['seller', 'category'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->paginate(12);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'condition' => 'required|string',
            'stock_quantity' => 'required|integer',
            'status' => 'nullable|string',
            'delivery_available' => 'boolean',
            'location' => 'nullable|string',
        ]);

        $product = Product::create($data);
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load(['category', 'seller', 'variations', 'media']));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
