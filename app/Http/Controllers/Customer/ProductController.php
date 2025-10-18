<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category','media','reviews')->paginate(20);
        return view('customer.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('customer.products.show', compact('product'));
    }
}
