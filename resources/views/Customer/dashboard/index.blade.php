@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
  <h1 class="text-2xl font-bold mb-4">Welcome back, {{ $user->name }} 👋</h1>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Recommendations -->
    <div class="col-span-2 bg-white shadow p-4 rounded-2xl">
      <h2 class="font-semibold mb-3">Recommended for you</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($recommendations as $product)
          <div class="border rounded-xl p-2 hover:shadow">
            <img src="{{ $product->media->first()->file_path ?? '/images/placeholder.png' }}" class="w-full h-32 object-cover rounded">
            <p class="font-medium mt-2">{{ $product->name }}</p>
            <p class="text-gray-500 text-sm">ZMW {{ $product->price }}</p>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Quick Summary -->
    <div class="bg-white shadow p-4 rounded-2xl space-y-3">
      <div>
        <h3 class="font-semibold">Recent Orders</h3>
        <ul class="text-sm mt-2 text-gray-700">
          @forelse($recentOrders as $order)
            <li class="border-b py-1">#{{ $order->id }} — {{ ucfirst($order->status) }}</li>
          @empty
            <li class="text-gray-500">No recent orders.</li>
          @endforelse
        </ul>
      </div>
      <div>
        <h3 class="font-semibold">Messages</h3>
        <ul class="text-sm mt-2 text-gray-700">
          @forelse($recentMessages as $msg)
            <li class="border-b py-1">{{ Str::limit($msg->content, 40) }}</li>
          @empty
            <li class="text-gray-500">No messages yet.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection
