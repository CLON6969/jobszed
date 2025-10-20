@extends('layouts.Seller')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Reply to Message</h1>
    <p class="text-gray-600">Respond to {{ $message->sender->name ?? 'Guest User' }} regarding {{ $message->product->name ?? 'this inquiry' }}.</p>
</div>

<form action="{{ route('Seller.messages.sendReply', $message->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-700 mb-1">Message</label>
        <textarea name="content" rows="5" class="border rounded w-full p-3" placeholder="Write your reply..." required></textarea>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('Seller.messages.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Cancel</a>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded">Send Reply</button>
    </div>
</form>
@endsection
