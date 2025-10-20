@extends('layouts.Customer')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-semibold mb-4">My Orders</h2>

    @if($orders->isEmpty())
        <p class="text-gray-600">You have no orders yet.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">Order #</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr>
                        <td class="px-4 py-2">#{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2">K{{ number_format($order->total_amount,2) }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('Customer.orders.show',$order) }}" class="text-indigo-600">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
