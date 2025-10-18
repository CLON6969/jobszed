<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // List products with filters and search
    public function index(Request $request)
    {
        $query = Product::query()->with(['media', 'seller', 'category']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('location')) {
            $query->where('location', 'ILIKE', "%{$request->location}%");
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return response()->json($query->paginate(12));
    }

    // View single product
    public function show(Product $product)
    {
        return response()->json($product->load(['media', 'variations', 'reviews']));
    }

    // Place an order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variation_id' => 'nullable|exists:product_variations,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $buyer = Auth::user();
        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $price = $product->price;

            if (!empty($item['variation_id'])) {
                $variation = $product->variations()->findOrFail($item['variation_id']);
                $price += $variation->price_adjustment;
            }

            $total += $price * $item['quantity'];
        }

        $order = Order::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $product->seller_id,
            'total_amount' => $total,
            'status' => 'pending',
            'fulfillment_type' => $request->fulfillment_type ?? 'delivery',
            'delivery_address' => $request->delivery_address,
            'scheduled_at' => $request->scheduled_at,
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $price = $product->price;

            $variationId = null;
            if (!empty($item['variation_id'])) {
                $variation = $product->variations()->find($item['variation_id']);
                $price += $variation->price_adjustment;
                $variationId = $variation->id;
            }

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'variation_id' => $variationId,
                'quantity' => $item['quantity'],
                'price' => $price,
                'subtotal' => $price * $item['quantity'],
            ]);

            // Decrement stock
            if ($variationId) {
                $variation->decrement('stock', $item['quantity']);
            } else {
                $product->decrement('stock_quantity', $item['quantity']);
            }
        }

        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }

    // Send message to seller
    public function messageSeller(Request $request, Product $product)
    {
        $request->validate(['content' => 'required|string|max:500']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->seller_id,
            'product_id' => $product->id,
            'content' => $request->content,
            'channel' => $request->channel ?? 'whatsapp',
            'status' => 'sent',
        ]);

        return response()->json(['message' => 'Message sent successfully', 'data' => $message]);
    }

    // View order history
    public function orders()
    {
        $orders = Auth::user()->orders()->with('items.product')->paginate(12);
        return response()->json($orders);
    }
}
