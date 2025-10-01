@extends('layouts.admin_dashboard')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Company Statements</h2>
        <a href="{{ route('admin.web.homepage.statements.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow">
            + Add New
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($statements->isEmpty())
        <p class="text-gray-600">No statements found.</p>
    @else
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Title</th>
                        <th class="px-4 py-3 text-left">Main Content</th>
                        <th class="px-4 py-3 text-left">Sub Content</th>
                        <th class="px-4 py-3 text-center">Background</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($statements as $s)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $s->title1 }}</td>
                            <td class="px-4 py-3">{{ Str::limit($s->title1_main_content, 40) }}</td>
                            <td class="px-4 py-3">{{ Str::limit($s->title1_sub_content, 40) }}</td>
                            <td class="px-4 py-3 text-center">
                                @if($s->background_picture)
                                    <img src="{{ asset('/public/storage/uploads/pics/' . $s->background_picture) }}" class="h-12 mx-auto rounded border">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('admin.web.homepage.statements.edit', $s->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">Edit</a>
                                <form action="{{ route('admin.web.homepage.statements.destroy', $s->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this statement?')">
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
            @foreach($statements as $s)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <h3 class="font-semibold text-gray-800">{{ $s->title1 }}</h3>
                    <p class="text-sm text-gray-600"><strong>Main:</strong> {{ Str::limit($s->title1_main_content, 60) }}</p>
                    <p class="text-sm text-gray-600"><strong>Sub:</strong> {{ Str::limit($s->title1_sub_content, 60) }}</p>

                    <div class="my-2">
                        @if($s->background_picture)
                            <img src="{{ asset('/public/storage/uploads/pics/' . $s->background_picture) }}" class="h-16 rounded border">
                        @else
                            <span class="text-gray-500">No Image</span>
                        @endif
                    </div>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('admin.web.homepage.statements.edit', $s->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">Edit</a>
                        <form action="{{ route('admin.web.homepage.statements.destroy', $s->id) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Delete this statement?')">
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
