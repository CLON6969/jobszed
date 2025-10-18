@extends('layouts.seller')

@section('content')
<div class="container">
    <h3>Chat with {{ $customer->name ?? 'Guest' }}</h3>
    @if($product)
        <p><strong>Product:</strong> {{ $product->name }}</p>
    @endif

    <div class="chat-box border rounded p-3 bg-light mb-3" style="height: 400px; overflow-y: auto;">
        @foreach($messages as $msg)
            <div class="mb-2 {{ $msg->sender_id == auth()->id() ? 'text-end' : '' }}">
                <div class="d-inline-block p-2 rounded {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white border' }}">
                    {{ $msg->content }}
                    <div class="small text-muted">{{ $msg->created_at->diffForHumans() }}</div>

                    @if($msg->sender_id == auth()->id() && $msg->created_at->diffInMinutes(now()) <= 15)
                        <a href="{{ route('Seller.messages.edit', $msg->id) }}" class="small text-light d-block">Edit</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <form action="{{ route('Seller.messages.send', [$customer->id, $product->id ?? null]) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
            <button class="btn btn-primary" type="submit">Send</button>
        </div>
    </form>
</div>
@endsection
