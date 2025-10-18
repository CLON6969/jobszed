@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Locations</h2>
        <a href="{{ route('user.applicant.locations.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Add Location
        </a>
    </div>

    @if($items->count())
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Province</th>
                        <th class="px-4 py-3 text-left">City</th>
                        <th class="px-4 py-3 text-left">Postal Code</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($items as $loc)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loc->location->province ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $loc->location->city ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ $loc->location->postal_code ?? '—' }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('user.applicant.locations.edit', $loc->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('user.applicant.locations.destroy', $loc->id) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this location?')">
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
            @foreach($items as $loc)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <h3 class="font-semibold text-gray-800">{{ $loc->location->city ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-600">Province: {{ $loc->location->province ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Postal: {{ $loc->location->postal_code ?? '—' }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('user.applicant.locations.edit', $loc->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('user.applicant.locations.destroy', $loc->id) }}"
                              method="POST" class="flex-1"
                              onsubmit="return confirm('Delete this location?')">
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
    @else
        <p class="text-gray-600">You haven't added any locations yet.</p>
    @endif
</div>
@endsection
