@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Logo List</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-6 shadow">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($logo->isEmpty())
        <p class="text-gray-600">No logos found.</p>
    @else
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-center">Picture 1</th>
                        <th class="px-4 py-3 text-center">Picture 2</th>
                        <th class="px-4 py-3 text-center">Background</th>
                        <th class="px-4 py-3 text-left">Home URL</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($logo as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $item->title }}</td>
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('/public/storage/uploads/logo/' . $item->picture) }}" class="h-10 mx-auto rounded">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('/public/storage/uploads/logo/' . $item->picture2) }}" class="h-10 mx-auto rounded">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <img src="{{ asset('/public/storage/uploads/logo/' . $item->background_picture) }}" class="h-10 mx-auto rounded">
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ $item->home_url }}" target="_blank" class="text-blue-600 underline break-words">
                                    {{ $item->home_url }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.web.general.logo.edit', $item->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('admin.web.general.logo.destroy', $item->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            @foreach($logo as $item)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <p class="text-sm text-gray-700"><strong>Title:</strong> {{ $item->title }}</p>

                    <div class="mt-2">
                        <p class="text-sm text-gray-700 font-semibold">Picture 1:</p>
                        <img src="{{ asset('/public/storage/uploads/logo/' . $item->picture) }}" class="h-12 mt-1 rounded">
                    </div>

                    <div class="mt-2">
                        <p class="text-sm text-gray-700 font-semibold">Picture 2:</p>
                        <img src="{{ asset('/public/storage/uploads/logo/' . $item->picture2) }}" class="h-12 mt-1 rounded">
                    </div>

                    <div class="mt-2">
                        <p class="text-sm text-gray-700 font-semibold">Background:</p>
                        <img src="{{ asset('/public/storage/uploads/logo/' . $item->background_picture) }}" class="h-12 mt-1 rounded">
                    </div>

                    <div class="mt-2">
                        <p class="text-sm text-gray-700 font-semibold">Home URL:</p>
                        <a href="{{ $item->home_url }}" target="_blank" class="text-blue-600 underline break-words">
                            {{ $item->home_url }}
                        </a>
                    </div>

                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('admin.web.general.logo.edit', $item->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.web.general.logo.destroy', $item->id) }}"
                              method="POST" class="flex-1"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
