<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ProductMedia;
use Illuminate\Support\Facades\Auth;

class ProductMediaController extends Controller
{
    /**
     * Customers can view product media (read-only).
     */
    public function index()
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        $media = ProductMedia::with('product')->latest()->paginate(15);
        return view('user.Customer.product_media.index', compact('media'));
    }

    /**
     * View a specific media item.
     */
    public function show(ProductMedia $productMedia)
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        $productMedia->load('product');
        return view('user.Customer.product_media.show', compact('productMedia'));
    }
}
