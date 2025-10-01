@extends('layouts.admin')

@section('title', 'Create Legal Document')

@section('content')
<div class="container py-5">
    <h1 class="text-2xl font-bold mb-4">Add Legal Document</h1>

    <form method="POST" action="{{ route('admin.web.legal.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Slug</label>
            <input type="text" name="slug" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Is Active?</label>
            <select name="is_active" class="w-full border rounded p-2">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Document</button>
        <a href="{{ route('admin.web.legal.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
