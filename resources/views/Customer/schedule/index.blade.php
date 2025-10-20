@extends('layouts.Customer')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-xl p-6">
    <h2 class="text-2xl font-semibold mb-4">Scheduled Orders</h2>

    @if($scheduled->isEmpty())
        <p class="text-gray-600">You have no scheduled orders.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($scheduled as $order)
                <li class="py-4 flex justify-between items-center">
                    <div>
                        <p><strong>Order #:</strong> {{ $order->id }}</p>
                        <p><strong>Scheduled At:</strong> {{ $order->scheduled_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('Customer.schedule.destroy', $order) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Cancel</button>
                        </form>
                        <form action="{{ route('Customer.schedule.store', $order) }}" method="POST">
                            @csrf
                            <input type="datetime-local" name="scheduled_at" class="border rounded px-2 py-1">
                            <button class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Update</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
