<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        return response()->json(OrderItem::with(['order', 'product'])->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'variation_id' => 'nullable|exists:product_variations,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);

        $item = OrderItem::create($data);
        return response()->json($item, 201);
    }

    public function show(OrderItem $orderItem)
    {
        return response()->json($orderItem->load(['order', 'product']));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $orderItem->update($request->all());
        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->json(['message' => 'Order item removed']);
    }
}
