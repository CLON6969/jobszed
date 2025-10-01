@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Footer Titles</h2>
        <a href="{{ route('admin.web.general.footer.titles.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Add New Title
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 shadow">{{ session('success') }}</div>
    @endif

    @if($titles->isEmpty())
        <p class="text-gray-600">No titles found.</p>
    @else
        <!-- Desktop -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Sort Order</th>
                        <th class="px-4 py-3 text-left">Active</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($titles as $title)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $title->title }}</td>
                            <td class="px-4 py-3">{{ $title->sort_order }}</td>
                            <td class="px-4 py-3">{{ $title->is_active ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.web.general.footer.titles.edit', $title->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('admin.web.general.footer.titles.destroy', $title->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile -->
        <div class="md:hidden space-y-4">
            @foreach($titles as $title)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <p><strong>Title:</strong> {{ $title->title }}</p>
                    <p><strong>Sort Order:</strong> {{ $title->sort_order }}</p>
                    <p><strong>Active:</strong> {{ $title->is_active ? 'Yes' : 'No' }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('admin.web.general.footer.titles.edit', $title->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.web.general.footer.titles.destroy', $title->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
