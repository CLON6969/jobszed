<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function Customer()
    {
        $customer = auth()->user();
        $ordersCount = Order::where('buyer_id', $customer->id)->count();
        $reviewsCount = Review::where('user_id', $customer->id)->count();
        $productsCount = Product::count(); // total products for customer browsing

        return view('customer.dashboard', compact('ordersCount','reviewsCount','productsCount'));
    }
}
