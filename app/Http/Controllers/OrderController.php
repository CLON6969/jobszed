<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the logged-in customer.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id !== 4) {
            abort(403, 'Unauthorized');
        }

        $orders = Order::where('buyer_id', $user->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('user.Customer.orders.index', compact('orders'));
    }

    /**
     * Show form to create a new order.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->latest()->get();
        return view('user.Customer.orders.create', compact('products'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role_id !== 4) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'delivery_method' => 'required|string|max:50',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withErrors(['stock' => 'Insufficient stock for this product.']);
        }

        DB::transaction(function () use ($user, $product, $request) {
            $order = Order::create([
                'buyer_id' => $user->id,
                'seller_id' => $product->user_id,
                'status' => 'pending',
                'total_amount' => $product->price * $request->quantity,
                'delivery_method' => $request->delivery_method,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
                'subtotal' => $product->price * $request->quantity,
            ]);

            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('user.Customer.orders.index')
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Display a specific order.
     */
    public function show(Order $order)
    {
        $this->authorizeOrderAccess($order);

        $order->load('items.product');

        return view('user.Customer.orders.show', compact('order'));
    }

    /**
     * Edit an existing order (if still pending).
     */
    public function edit(Order $order)
    {
        $this->authorizeOrderAccess($order);

        if ($order->status !== 'pending') {
            return back()->withErrors(['status' => 'This order cannot be modified anymore.']);
        }

        return view('user.Customer.orders.edit', compact('order'));
    }

    /**
     * Update an order (e.g., change delivery method).
     */
    public function update(Request $request, Order $order)
    {
        $this->authorizeOrderAccess($order);

        $request->validate([
            'delivery_method' => 'required|string|max:50',
        ]);

        $order->update([
            'delivery_method' => $request->delivery_method,
        ]);

        return redirect()->route('user.Customer.orders.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Cancel an order (only if pending).
     */
    public function destroy(Order $order)
    {
        $this->authorizeOrderAccess($order);

        if ($order->status !== 'pending') {
            return back()->withErrors(['status' => 'Only pending orders can be cancelled.']);
        }

        $order->update(['status' => 'cancelled']);
        return redirect()->route('user.Customer.orders.index')->with('success', 'Order cancelled.');
    }

    /**
     * Private method: ensure order belongs to the current user.
     */
    private function authorizeOrderAccess(Order $order)
    {
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }
    }
}
