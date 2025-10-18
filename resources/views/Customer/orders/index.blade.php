@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">My Orders</h2>

<a href="{{ route('user.Customer.orders.create') }}" class="btn btn-primary mb-4">Place New Order</a>

<div class="bg-white shadow rounded-lg p-4">
    @forelse ($orders as $order)
        <div class="border-b py-3">
            <p><strong>Order #{{ $order->id }}</strong> | Status: <span class="text-blue-600">{{ ucfirst($order->status) }}</span></p>
            <p>Total: ZMW {{ number_format($order->total_amount, 2) }}</p>
            <a href="{{ route('user.Customer.orders.show', $order) }}" class="btn btn-info btn-sm mt-2">View</a>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
