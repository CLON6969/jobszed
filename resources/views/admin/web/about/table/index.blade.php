@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">About Table Entries</h2>
        <a href="{{ route('admin.web.about.table.create') }}"
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
        <p class="text-gray-600">No entries found.</p>
    @else
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-center">Picture</th>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Small Text</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($records as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-center">
                                @if($row->picture)
                                    <img src="{{ asset('/public/storage/uploads/pics/' . $row->picture) }}" class="h-12 rounded">
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $row->title1 }}</td>
                            <td class="px-4 py-3">{{ Str::limit($row->title1_small_text, 40) }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.web.about.table.edit', $row->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('admin.web.about.table.destroy', $row->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this entry?')">
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
            @foreach($records as $row)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    @if($row->picture)
                        <img src="{{ asset('/public/storage/uploads/pics/' . $row->picture) }}" class="h-20 rounded mb-2">
                    @endif
                    <h3 class="font-semibold text-gray-800">{{ $row->title1 }}</h3>
                    <p class="text-sm text-gray-600"><strong>Small Text:</strong> {{ Str::limit($row->title1_small_text, 60) }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('admin.web.about.table.edit', $row->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.web.about.table.destroy', $row->id) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Delete this entry?')">
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
