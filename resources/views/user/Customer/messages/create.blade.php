@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Start a Conversation</h2>

<form action="{{ route('user.Customer.messages.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Seller</label>
        <select name="receiver_id" class="form-select w-full" required>
            <option value="">Select Seller</option>
            @foreach($sellers as $seller)
                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Message</label>
        <textarea name="message" class="form-textarea w-full" rows="4" placeholder="Write your message..." required></textarea>
    </div>

    <button class="btn btn-primary">Send Message</button>
</form>
@endsection
