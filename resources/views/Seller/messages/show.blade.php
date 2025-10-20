{{-- resources/views/Seller/messages/show.blade.php --}}
@extends('layouts.Seller')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden flex flex-col h-[80vh]">
    <div class="flex items-center justify-between p-4 border-b">
        <div>
            <h2 class="font-semibold text-lg">{{ $customer->name }}</h2>
            @if($product)
                <p class="text-sm text-gray-500">Regarding: {{ $product->name }}</p>
            @endif
        </div>
        <a href="{{ route('Seller.messages.index') }}" class="text-blue-500 text-sm">← Back</a>
    </div>

    {{-- Chat messages --}}
    <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-2 bg-gray-50">
        @foreach($messages as $msg)
            @php
                $isMine = $msg->sender_id === auth()->id();
                $productInfo = $msg->metadata ?? [];
            @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] rounded-2xl px-4 py-2 {{ $isMine ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                    
                    {{-- Product info (from message metadata) --}}
                    @if(isset($productInfo['id']))
                        <div class="mb-2 p-2 bg-gray-100 rounded-lg border text-sm">
                            <strong>Product:</strong> <a href="{{ $productInfo['link'] ?? '#' }}" class="text-blue-600 underline">{{ $productInfo['name'] }}</a><br>
                            <strong>Price:</strong> ZMW {{ number_format($productInfo['price'], 2) }}
                        </div>
                    @endif

                    {{-- Media --}}
                    @if(isset($productInfo['media']))
                        <div class="mb-2">
                            @if(Str::startsWith($productInfo['media_type'], 'image'))
                                <img src="{{ asset('storage/' . $productInfo['media']) }}" class="rounded-lg max-h-48 cursor-pointer">
                            @elseif(Str::startsWith($productInfo['media_type'], 'video'))
                                <video controls class="rounded-lg max-h-48">
                                    <source src="{{ asset('storage/' . $productInfo['media']) }}">
                                </video>
                            @endif
                            <a href="{{ asset('storage/' . $productInfo['media']) }}" download class="text-xs text-gray-200 underline block mt-1">Download</a>
                        </div>
                    @endif

                    {{-- Message content --}}
                    @if($msg->status === 'deleted')
                        <p class="italic text-gray-400">This message was deleted</p>
                    @else
                        {{ $msg->content }}
                    @endif

                    {{-- Reply indicator --}}
                    @if(isset($productInfo['reply_to']))
                        <p class="text-xs text-gray-400 mt-1">↪ Replied to message #{{ $productInfo['reply_to'] }}</p>
                    @endif

                    <p class="text-[10px] text-gray-300 mt-1 text-right">
                        {{ $msg->created_at->format('H:i') }}
                        @if($isMine && $msg->status === 'read')
                            ✓✓
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Send message form --}}
    <form method="POST" action="{{ route('Seller.messages.send', [$customer->id, $product?->id]) }}" enctype="multipart/form-data" class="p-4 border-t flex items-center space-x-2">
        @csrf
        <input type="text" name="content" class="flex-1 border rounded-full px-4 py-2 focus:ring focus:ring-blue-200" placeholder="Type a message..." required>

        <input type="file" name="media" class="hidden" id="mediaInput" accept="image/*,video/*,application/*">
        <button type="button" onclick="document.getElementById('mediaInput').click()" class="text-gray-500 hover:text-blue-600">
            📎
        </button>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">
            Send
        </button>
    </form>
</div>
@endsection
{{-- resources/views/Seller/messages/index.blade.php --}}
@extends('layouts.Seller')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Messages</h2>

    @if($threads->isEmpty())
        <p class="text-gray-500">No conversations yet.</p>
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
                        <a href="{{ route('Seller.messages.show', [$otherUser->id, $productId !== 'none' ? $productId : null]) }}" class="font-medium text-gray-800 hover:text-blue-600">
                            {{ $otherUser->name }}
                        </a>
                        @if($first->product)
                            <p class="text-sm text-gray-500">Regarding: {{ $first->product->name }}</p>
                        @endif
                        <p class="text-sm text-gray-600 truncate">{{ $first->content }}</p>
                    </div>
                    <span class="text-xs text-gray-400">{{ $first->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
