@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Conversation with {{ $user->name }}</h2>

<div class="bg-gray-100 p-4 rounded-lg max-h-[60vh] overflow-y-auto">
    @foreach($messages as $msg)
        <div class="mb-3 {{ $msg->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
            <div class="inline-block px-4 py-2 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                {{ $msg->message }}
                @if($msg->edited_at)
                    <span class="text-xs italic opacity-75">(edited)</span>
                @endif
            </div>
            <div class="text-xs text-gray-500 mt-1">
                {{ $msg->created_at->format('d M Y, H:i') }}
            </div>
        </div>

        @if($msg->sender_id === auth()->id())
            <div class="flex justify-end gap-2 mb-4">
                <a href="{{ route('user.Customer.messages.edit', $msg->id) }}" class="text-blue-600 text-sm">Edit</a>
                <form action="{{ route('user.Customer.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm">Delete</button>
                </form>
            </div>
        @endif
    @endforeach
</div>

<form action="{{ route('user.Customer.messages.store') }}" method="POST" class="mt-4 flex gap-2">
    @csrf
    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
    <input type="text" name="message" placeholder="Type a message..." class="flex-grow form-input" required>
    <button class="btn btn-primary">Send</button>
</form>
@endsection
