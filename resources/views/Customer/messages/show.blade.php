{{-- resources/views/Customer/messages/show.blade.php --}}
@extends('layouts.Customer')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-lg overflow-hidden flex flex-col h-[80vh]">
    <div class="flex items-center justify-between p-4 border-b">
        <div>
            <h2 class="font-semibold text-lg">{{ $seller->name }}</h2>
            @if($product)
                <p class="text-sm text-gray-500">Regarding: {{ $product->title }}</p>
            @endif
        </div>
        <a href="{{ route('Customer.messages.index') }}" class="text-blue-500 text-sm">← Back</a>
    </div>

    <div id="chat-box" class="flex-1 overflow-y-auto p-4 space-y-2 bg-gray-50">
        @foreach($messages as $msg)
            @php
                $isMine = $msg->sender_id === auth()->id();
            @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] rounded-2xl px-4 py-2 {{ $isMine ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                    
                    {{-- MEDIA --}}
                    @if(isset($msg->metadata['media']))
                        <div class="mb-2">
                            @if(Str::startsWith($msg->metadata['media_type'], 'image'))
                                <img src="{{ asset('storage/' . $msg->metadata['media']) }}" class="rounded-lg max-h-48 cursor-pointer">
                            @elseif(Str::startsWith($msg->metadata['media_type'], 'video'))
                                <video controls class="rounded-lg max-h-48">
                                    <source src="{{ asset('storage/' . $msg->metadata['media']) }}">
                                </video>
                            @else
                                <a href="{{ route('Customer.messages.download', $msg->id) }}" class="underline text-sm">📎 Download File</a>
                            @endif
                        </div>
                    @endif

                    {{-- MESSAGE CONTENT --}}
                    @if($msg->status === 'deleted')
                        <p class="italic text-gray-400">This message was deleted</p>
                    @else
                        {{ $msg->content }}
                    @endif

                    {{-- REPLY INFO --}}
                    @if(isset($msg->metadata['reply_to']))
                        <p class="text-xs text-gray-400 mt-1">↪ Reply to #{{ $msg->metadata['reply_to'] }}</p>
                    @endif

                    <p class="text-[10px] text-gray-300 mt-1 text-right">{{ $msg->created_at->format('H:i') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MESSAGE FORM --}}
    <form method="POST" action="{{ route('Customer.messages.send', [$seller->id, $product?->id]) }}" enctype="multipart/form-data" class="p-4 border-t flex items-center space-x-2">
        @csrf
        <input type="text" name="content" class="flex-1 border rounded-full px-4 py-2 focus:ring focus:ring-green-200" placeholder="Type a message...">
        
        <input type="file" name="media" id="mediaInput" class="hidden" accept="image/*,video/*,application/*">
        <button type="button" onclick="document.getElementById('mediaInput').click()" class="text-gray-500 hover:text-green-600">
            📎
        </button>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600">
            Send
        </button>
    </form>
</div>
@endsection
