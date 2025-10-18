@extends('layouts.customer')

@section('content')
<h2 class="text-2xl font-semibold mb-4">My Conversations</h2>

<a href="{{ route('user.Customer.messages.create') }}" class="btn btn-primary mb-4">Start New Conversation</a>

<div class="bg-white shadow rounded-lg p-4">
    @forelse ($messages as $message)
        <div class="border-b py-3">
            <p><strong>To:</strong> {{ $message->receiver->name }}</p>
            <p>{{ Str::limit($message->message, 100) }}</p>
            <a href="{{ route('user.Customer.messages.show', $message->receiver_id) }}" class="btn btn-info btn-sm mt-2">View Chat</a>
        </div>
    @empty
        <p>No messages found.</p>
    @endforelse
</div>

<div class="mt-4">
    {{ $messages->links() }}
</div>
@endsection
