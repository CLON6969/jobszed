@extends('layouts.admin')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Message</h2>

<form action="{{ route('admin.messages.update', $message->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="message" class="block font-medium mb-2">Message Content</label>
        <textarea name="message" id="message" rows="4" class="w-full border-gray-300 rounded-lg" required>{{ old('message', $message->message) }}</textarea>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form>
@endsection
