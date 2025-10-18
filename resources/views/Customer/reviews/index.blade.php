@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">My Reviews</h2>

<a href="{{ route('user.Customer.reviews.create') }}" class="btn btn-primary mb-4">Write New Review</a>

<div class="bg-white shadow rounded-lg p-4">
    @forelse ($reviews as $review)
        <div class="border-b py-3">
            <p><strong>{{ $review->product->name }}</strong></p>
            <p>Rating: ⭐ {{ $review->rating }}/5</p>
            <p>{{ $review->comment }}</p>
            <a href="{{ route('user.Customer.reviews.show', $review) }}" class="btn btn-info btn-sm mt-2">View</a>
        </div>
    @empty
        <p>No reviews found.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $reviews->links() }}
</div>
@endsection
