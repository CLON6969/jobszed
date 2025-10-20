{{-- resources/views/Seller/messages/edit.blade.php --}}
@extends('layouts.Seller')

@section('content')
<div class="max-w-md mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold mb-4">Edit Message</h2>

    <form method="POST" action="{{ route('Seller.messages.update', $message->id) }}">
        @csrf
        @method('PUT')

        <textarea name="content" class="w-full border rounded-lg p-2 mb-3" rows="4" required>{{ old('content', $message->content) }}</textarea>

        <div class="flex justify-end space-x-2">
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 rounded-lg">Cancel</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
        </div>
    </form>
</div>
@endsection
