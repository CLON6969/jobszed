@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">My Experiences</h2>
        <a href="{{ route('user.applicant.experiences.create') }}"
           class="mt-3 md:mt-0 inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition">
            + Add Experience
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($items->count())
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Employer</th>
                        <th class="px-4 py-3 text-left">Job Title</th>
                        <th class="px-4 py-3 text-left">Duration</th>
                        <th class="px-4 py-3 text-left">Description</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($items as $exp)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $exp->employer }}</td>
                            <td class="px-4 py-3">{{ $exp->job_title }}</td>
                            <td class="px-4 py-3">{{ $exp->start_date }} – {{ $exp->end_date ?? 'Present' }}</td>
                            <td class="px-4 py-3">{{ Str::limit($exp->description, 50) }}</td>
                            <td class="px-4 py-3 text-center space-x-2">
                                <a href="{{ route('user.applicant.experiences.edit', $exp->id) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('user.applicant.experiences.destroy', $exp->id) }}"
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
            @foreach($items as $exp)
                <div class="border rounded-lg shadow-sm p-4 bg-white">
                    <h3 class="font-semibold text-gray-800">{{ $exp->job_title }}</h3>
                    <p class="text-sm text-gray-600">Employer: {{ $exp->employer }}</p>
                    <p class="text-sm text-gray-600">Duration: {{ $exp->start_date }} – {{ $exp->end_date ?? 'Present' }}</p>
                    <p class="text-sm text-gray-600">Desc: {{ Str::limit($exp->description, 80) }}</p>

                    <div class="mt-3 flex space-x-2">
                        <a href="{{ route('user.applicant.experiences.edit', $exp->id) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('user.applicant.experiences.destroy', $exp->id) }}"
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
        <p class="text-gray-600">No experiences added yet.</p>
    @endif
</div>
@endsection
