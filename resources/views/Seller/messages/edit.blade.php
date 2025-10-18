@extends('layouts.seller')

@section('content')
<div class="container">
    <h3>Edit Message</h3>

    <form action="{{ route('Seller.messages.update', $message->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">Message Content</label>
            <textarea name="content" class="form-control" rows="3" required>{{ str_replace(' (edited)', '', $message->content) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </form>
</div>
@endsection
