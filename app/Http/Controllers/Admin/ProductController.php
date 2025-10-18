<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('seller','category')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'price'=>'required|numeric',
            'stock_quantity'=>'required|integer',
            'status'=>'required|string',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.product.index')->with('success','Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.product.index')->with('success','Product deleted');
    }
}
