@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Review</h2>

<form action="{{ route('user.Customer.reviews.update', $review) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Rating</label>
        <select name="rating" class="form-select w-full" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select>
    </div>

    <div>
        <label>Comment</label>
        <textarea name="comment" class="form-textarea w-full" rows="4">{{ $review->comment }}</textarea>
    </div>

    <button class="btn btn-primary">Update Review</button>
</form>
@endsection
