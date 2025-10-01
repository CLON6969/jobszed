@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Certifications</h2>
        <a href="{{ route('user.applicant.certifications.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Add Certification
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($items->count())
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Organization</th>
                        <th class="px-4 py-3 text-left">Obtained Date</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($items as $cert)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $cert->name }}</td>
                            <td class="px-4 py-3">{{ $cert->certification_type }}</td>
                            <td class="px-4 py-3">{{ $cert->issuing_organization }}</td>
                            <td class="px-4 py-3">{{ $cert->obtained_date }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('user.applicant.certifications.edit', $cert->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('user.applicant.certifications.destroy', $cert->id) }}"
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
            @foreach($items as $cert)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <h3 class="font-semibold text-gray-800">{{ $cert->name }}</h3>
                    <p class="text-sm text-gray-600">Type: {{ $cert->certification_type }}</p>
                    <p class="text-sm text-gray-600">Org: {{ $cert->issuing_organization }}</p>
                    <p class="text-sm text-gray-600">Date: {{ $cert->obtained_date }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('user.applicant.certifications.edit', $cert->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('user.applicant.certifications.destroy', $cert->id) }}"
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
    @else
        <p class="text-gray-600">No certifications added yet.</p>
    @endif
</div>
@endsection
