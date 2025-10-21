@extends('layouts.Seller')

@section('title', 'Orders Analytics')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">📦 Seller Orders Overview</h1>

    @if ($orders->count() > 0)
        <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 text-gray-700 uppercase text-sm font-medium">
                    <tr>
                        <th class="px-6 py-3 text-left">Order #</th>
                        <th class="px-6 py-3 text-left">Customer</th>
                        <th class="px-6 py-3 text-left">Items</th>
                        <th class="px-6 py-3 text-left">Total (ZMW)</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-indigo-600">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4">
                                @if($order->customer)
                                    <div class="font-medium">{{ $order->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->customer->email }}</div>
                                @else
                                    <span class="text-gray-400 italic">Guest</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($order->items as $item)
                                        <li class="text-sm">
                                            {{ $item->product->name ?? 'Deleted Product' }} 
                                            <span class="text-gray-500">x{{ $item->quantity }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                ZMW {{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-medium rounded-full
                                    @if($order->status === 'completed') bg-green-100 text-green-700
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links('pagination::tailwind') }}
        </div>
    @else
        <div class="bg-white p-8 rounded-xl shadow text-center">
            <h2 class="text-lg font-medium text-gray-700 mb-2">No orders found</h2>
            <p class="text-gray-500">You haven’t received any orders yet.</p>
        </div>
    @endif
</div>
@endsection
