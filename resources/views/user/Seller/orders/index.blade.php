@extends('layouts.seller')
@section('title', 'Orders')

@section('seller-content')
<h1 class="text-2xl font-semibold mb-4">My Orders</h1>

<table class="w-full border-collapse">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 text-left">Order #</th>
            <th class="p-2 text-left">Customer</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">Total</th>
            <th class="p-2 text-left">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-b">
            <td class="p-2">{{ $order->id }}</td>
            <td class="p-2">{{ $order->user->name }}</td>
            <td class="p-2 capitalize">{{ $order->status }}</td>
            <td class="p-2">ZMW {{ number_format($order->total, 2) }}</td>
            <td class="p-2">{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
