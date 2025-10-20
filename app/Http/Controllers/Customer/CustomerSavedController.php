<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CustomerSavedController extends Controller
{
    // List saved products
    public function index()
    {
        $saved = Auth::user()->savedProducts()->with('media')->get();
        return view('Customer.saved.index', compact('saved'));
    }

    // Save product to wishlist
    public function store(Product $product)
    {
        Auth::user()->savedProducts()->syncWithoutDetaching([$product->id]);
        return back()->with('success', 'Product saved!');
    }

    // Remove product from wishlist
    public function destroy(Product $product)
    {
        Auth::user()->savedProducts()->detach($product->id);
        return back()->with('success', 'Product removed from saved.');
    }
}
