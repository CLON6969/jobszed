@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Write a Review</h2>

<form action="{{ route('user.Customer.reviews.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Product</label>
        <select name="product_id" class="form-select w-full" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} (Seller: {{ $product->user->name }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Rating</label>
        <select name="rating" class="form-select w-full" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
    </div>

    <div>
        <label>Comment</label>
        <textarea name="comment" class="form-textarea w-full" rows="4" placeholder="Write your feedback..."></textarea>
    </div>

    <button class="btn btn-primary">Submit Review</button>
</form>
@endsection
