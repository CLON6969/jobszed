{{-- resources/views/Customer/messages/index.blade.php --}}
@extends('layouts.Customer')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Your Conversations</h2>

    @if($threads->isEmpty())
        <p class="text-gray-500">You have no conversations yet.</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($threads as $key => $messages)
                @php
                    $first = $messages->last();
                    [$otherUserId, $productId] = explode('_', $key);
                    $otherUser = $first->sender_id === auth()->id() ? $first->receiver : $first->sender;
                @endphp
                <li class="py-3 flex items-center justify-between">
                    <div>
                        <a href="{{ route('Customer.messages.show', [$otherUser->id, $productId !== 'none' ? $productId : null]) }}" class="font-medium text-gray-800 hover:text-blue-600">
                            {{ $otherUser->name }}
                        </a>
                        @if($first->product)
                            <p class="text-sm text-gray-500">Regarding: {{ $first->product->title }}</p>
                        @endif
                        <p class="text-sm text-gray-600 truncate">{{ $first->content ?: 'Media attachment' }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $first->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
