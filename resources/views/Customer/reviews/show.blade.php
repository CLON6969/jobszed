@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Review Details</h2>

<div class="bg-white p-4 rounded-lg shadow">
    <p><strong>Product:</strong> {{ $review->product->name }}</p>
    <p><strong>Seller:</strong> {{ $review->seller->name }}</p>
    <p><strong>Rating:</strong> ⭐ {{ $review->rating }}/5</p>
    <p><strong>Comment:</strong> {{ $review->comment }}</p>

    <div class="mt-4">
        <a href="{{ route('user.Customer.reviews.edit', $review) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('user.Customer.reviews.destroy', $review) }}" method="POST" class="inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Delete this review?')">Delete</button>
        </form>
        <a href="{{ route('user.Customer.reviews.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
