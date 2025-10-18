<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\Auth;

class ProductVariationController extends Controller
{
    /**
     * Customers can view product variations.
     */
    public function index()
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        $variations = ProductVariation::with('product')->latest()->paginate(15);
        return view('user.Customer.product_variations.index', compact('variations'));
    }

    /**
     * Show a specific variation.
     */
    public function show(ProductVariation $productVariation)
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        $productVariation->load('product');
        return view('user.Customer.product_variations.show', compact('productVariation'));
    }
}
