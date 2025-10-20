<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('Customer.dashboard.index', [
            'user' => $user,
            'recommendations' => Product::inRandomOrder()->take(6)->get(),
            'recentOrders' => $user->orders()->latest()->take(5)->get(),
            'recentMessages' => Message::where('receiver_id', $user->id)->latest()->take(5)->get(),
        ]);
    }
}
