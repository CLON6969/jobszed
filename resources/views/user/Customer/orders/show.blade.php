@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Order Details</h2>

<div class="bg-white p-4 rounded-lg shadow">
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total:</strong> ZMW {{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Delivery:</strong> {{ ucfirst($order->delivery_method) }}</p>

    <h3 class="mt-4 text-xl font-semibold">Items</h3>
    <ul class="list-disc ml-5">
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} (x{{ $item->quantity }}) — ZMW {{ number_format($item->subtotal, 2) }}</li>
        @endforeach
    </ul>

    <div class="mt-4">
        @if ($order->status === 'pending')
            <a href="{{ route('user.Customer.orders.edit', $order) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('user.Customer.orders.destroy', $order) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Cancel this order?')">Cancel</button>
            </form>
        @endif
        <a href="{{ route('user.Customer.orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
