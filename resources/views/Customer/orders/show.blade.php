@extends('layouts.Customer')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h2>

    <div class="mb-4">
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Total:</strong> K{{ number_format($order->total_amount,2) }}</p>
        <p><strong>Seller:</strong> {{ $order->seller->business_name ?? 'N/A' }}</p>
        <p><strong>Scheduled At:</strong> {{ $order->scheduled_at ?? 'Not scheduled' }}</p>
    </div>

    <h3 class="font-semibold mb-2">Items</h3>
    <ul class="divide-y divide-gray-200">
        @foreach($order->items as $item)
            <li class="py-2 flex justify-between">
                <span>{{ $item->product->name }}</span>
                <span>K{{ number_format($item->subtotal,2) }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
