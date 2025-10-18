@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Messages Involving {{ $user->name }}</h2>

<div class="bg-gray-100 p-4 rounded-lg max-h-[60vh] overflow-y-auto">
    @foreach($messages as $msg)
        <div class="mb-3 {{ $msg->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
            <div class="inline-block px-4 py-2 rounded-lg {{ $msg->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-300' }}">
                <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
                @if($msg->edited_at)
                    <span class="text-xs italic opacity-75">(edited)</span>
                @endif
            </div>
            <div class="text-xs text-gray-500 mt-1">
                {{ $msg->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    @endforeach
</div>
@endsection
