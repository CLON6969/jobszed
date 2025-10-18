@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Order</h2>

<form action="{{ route('user.Customer.orders.update', $order) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Delivery Method</label>
        <select name="delivery_method" class="form-select w-full" required>
            <option value="pickup" {{ $order->delivery_method === 'pickup' ? 'selected' : '' }}>Pickup</option>
            <option value="delivery" {{ $order->delivery_method === 'delivery' ? 'selected' : '' }}>Delivery</option>
            <option value="schedule_meeting" {{ $order->delivery_method === 'schedule_meeting' ? 'selected' : '' }}>Schedule Meeting</option>
        </select>
    </div>

    <button class="btn btn-primary">Save Changes</button>
</form>
@endsection
