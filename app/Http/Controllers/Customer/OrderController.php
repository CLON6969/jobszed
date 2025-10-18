<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())->with('items.product','items.variation')->paginate(20);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('customer.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        // Implement order placement logic here
    }
}
