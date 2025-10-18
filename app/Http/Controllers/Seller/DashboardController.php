<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Seller()
    {
        $seller = auth()->user();
        $productsCount = Product::where('seller_id', $seller->id)->count();
        $ordersCount = Order::where('seller_id', $seller->id)->count();
        $reviewsCount = Review::whereHas('product', fn($q)=> $q->where('seller_id', $seller->id))->count();

        return view('seller.dashboard', compact('productsCount', 'ordersCount', 'reviewsCount'));
    }
}
