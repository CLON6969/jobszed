@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Place a New Order</h2>

<form action="{{ route('user.Customer.orders.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Product</label>
        <select name="product_id" class="form-select w-full" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - ZMW {{ number_format($product->price, 2) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Quantity</label>
        <input type="number" name="quantity" min="1" class="form-input w-full" required>
    </div>

    <div>
        <label>Delivery Method</label>
        <select name="delivery_method" class="form-select w-full" required>
            <option value="pickup">Pickup</option>
            <option value="delivery">Delivery</option>
            <option value="schedule_meeting">Schedule Meeting</option>
        </select>
    </div>

    <button class="btn btn-primary">Submit Order</button>
</form>
@endsection
