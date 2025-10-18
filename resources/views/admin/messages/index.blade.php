@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">All Messages</h2>

@if($messages->count())
    <div class="bg-white rounded-lg shadow p-4">
        @foreach($messages as $msg)
            <div class="border-b py-3 flex justify-between items-center">
                <div>
                    <strong>{{ $msg->sender->name }}</strong> → <strong>{{ $msg->receiver->name }}</strong>
                    <p class="text-sm">{{ Str::limit($msg->message, 80) }}
                        @if($msg->edited_at)
                            <span class="text-xs italic">(edited)</span>
                        @endif
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.messages.edit', $msg->id) }}" class="text-blue-600 text-sm">Edit</a>
                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
@else
    <p>No messages found.</p>
@endif
@endsection
