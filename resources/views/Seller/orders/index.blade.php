@extends('layouts.Customer')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-6">
  <h2 class="text-2xl font-semibold mb-6 text-gray-800">My Orders</h2>

  @if($orders->isEmpty())
    <p class="text-gray-600">You have no orders yet.</p>
  @else
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 text-gray-700">
          <tr>
            <th class="px-4 py-3 text-left text-sm font-semibold">Order #</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
            <th class="px-4 py-3 text-left text-sm font-semibold">Date</th>
            <th class="px-4 py-3 text-right text-sm font-semibold">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach($orders as $order)
            <tr>
              <td class="px-4 py-3 text-sm text-gray-800">#{{ $order->id }}</td>
              <td class="px-4 py-3">
                <span class="px-2 py-1 rounded-full text-xs font-medium 
                  {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                    ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                  {{ ucfirst($order->status) }}
                </span>
              </td>
              <td class="px-4 py-3 text-gray-700">K{{ number_format($order->total_amount, 2) }}</td>
              <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
              <td class="px-4 py-3 text-right">
                <a href="{{ route('Customer.orders.show', $order) }}" 
                   class="text-indigo-600 hover:text-indigo-800 font-medium">
                  View
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="mt-6">
      {{ $orders->links() }}
    </div>
  @endif
</div>
@endsection
