@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Home Table Records</h2>
        <a href="{{ route('admin.web.homepage.table.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Add New
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($records->isEmpty())
        <p class="text-gray-600">No records found.</p>
    @else
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-center">Picture</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Content</th>
                        <th class="px-4 py-3 text-left">Small Text</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($records as $record)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('/public/storage/uploads/pics/' . $record->picture) }}" class="h-12 rounded">
                            </td>
                            <td class="px-4 py-3">{{ $record->title1 }}</td>
                            <td class="px-4 py-3">{{ Str::limit($record->title1_content, 40) }}</td>
                            <td class="px-4 py-3">{{ Str::limit($record->title1_small_text, 40) }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.web.homepage.table.edit', $record->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('admin.web.homepage.table.destroy', $record->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            @foreach($records as $record)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <img src="{{ asset('/public/storage/uploads/pics/' . $record->picture) }}" class="h-20 rounded mb-2">
                    <h3 class="font-semibold text-gray-800">{{ $record->title1 }}</h3>
                    <p class="text-sm text-gray-600"><strong>Content:</strong> {{ Str::limit($record->title1_content, 60) }}</p>
                    <p class="text-sm text-gray-600"><strong>Small Text:</strong> {{ Str::limit($record->title1_small_text, 60) }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('admin.web.homepage.table.edit', $record->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.web.homepage.table.destroy', $record->id) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
