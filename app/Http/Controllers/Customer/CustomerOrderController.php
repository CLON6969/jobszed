<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with(['items.product'])
            ->latest()
            ->get();

        return view('Customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->buyer_id === Auth::id(), 403);

        $order->load(['items.product']);
        return view('Customer.orders.show', compact('order'));
    }
}
