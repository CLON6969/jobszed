@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Customer Conversations</h2>

@if($messages->count())
    <div class="bg-white rounded-lg shadow p-4">
        @foreach($messages as $msg)
            @php
                $contact = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender;
            @endphp
            <div class="border-b py-3 flex justify-between items-center">
                <a href="{{ route('user.Seller.messages.show', $contact->id) }}" class="flex items-center gap-3">
                    <img src="{{ asset('storage/' . $contact->profile_picture) }}" alt="profile" class="w-10 h-10 rounded-full">
                    <div>
                        <h4 class="font-semibold">{{ $contact->name }}</h4>
                        <p class="text-sm text-gray-500">{{ Str::limit($msg->message, 50) }}</p>
                    </div>
                </a>
                <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
            </div>
        @endforeach
    </div>
@else
    <p>No messages yet.</p>
@endif
@endsection
