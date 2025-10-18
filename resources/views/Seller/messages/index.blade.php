@extends('layouts.seller')

@section('content')
<div class="container">
    <h2>Customer Conversations</h2>
    <div class="list-group mt-4">
        @forelse($threads as $key => $thread)
            @php
                $first = $thread->first();
                $other = $first->sender_id == auth()->id() ? $first->receiver : $first->sender;
                $product = $first->product;
            @endphp

            <a href="{{ route('Seller.messages.show', [$other->id, $product->id ?? null]) }}" class="list-group-item list-group-item-action">
                <strong>{{ $other->name ?? 'Guest' }}</strong><br>
                <small>{{ $product->name ?? 'General Inquiry' }}</small><br>
                <span class="text-muted">{{ Str::limit($thread->last()->content, 50) }}</span>
            </a>
        @empty
            <p>No conversations yet.</p>
        @endforelse
    </div>
</div>
@endsection
