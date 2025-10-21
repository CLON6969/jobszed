@extends('layouts.Customer')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Order #{{ $order->id }}</h2>
    <span class="px-3 py-1 rounded-full text-sm font-medium 
      {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
        ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
      {{ ucfirst($order->status) }}
    </span>
  </div>

  <div class="mb-6">
    <p class="text-gray-600"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
    <p class="text-gray-600"><strong>Total:</strong> K{{ number_format($order->total_amount, 2) }}</p>
    <p class="text-gray-600"><strong>Fulfillment:</strong> {{ ucfirst($order->fulfillment_type) }}</p>
    <p class="text-gray-600"><strong>Seller:</strong> {{ $order->Seller->business_name ?? 'N/A' }}</p>
  </div>

  <h3 class="text-lg font-semibold mb-3 text-gray-800">Order Items</h3>

  <div class="divide-y divide-gray-200">
    @foreach($order->items as $item)
      <div class="py-4 flex justify-between items-center">
        <div>
          <p class="font-medium text-gray-800">{{ $item->product->name }}</p>
          <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
        </div>
        <p class="text-gray-700">K{{ number_format($item->subtotal, 2) }}</p>
      </div>
    @endforeach
  </div>
</div>
@endsection
