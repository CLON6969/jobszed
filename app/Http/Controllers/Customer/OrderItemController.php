<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderItemController extends Controller
{
    /**
     * Display all order items for the logged-in customer's orders.
     */
    public function index()
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        $orderItems = OrderItem::whereHas('order', function ($query) {
                $query->where('buyer_id', Auth::id());
            })
            ->with(['order', 'product'])
            ->latest()
            ->paginate(10);

        return view('user.Customer.orderItems.index', compact('orderItems'));
    }

    /**
     * Show a specific order item.
     */
    public function show(OrderItem $orderItem)
    {
        if (Auth::user()->role_id !== 4) abort(403, 'Unauthorized');

        if ($orderItem->order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $orderItem->load(['order', 'product']);
        return view('user.Customer.orderItems.show', compact('orderItem'));
    }
}
