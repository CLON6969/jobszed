@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">

    <!-- Header / Actions -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 space-y-4 md:space-y-0">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900">Job Posts</h2>
            <p class="text-gray-500 mt-1">Manage your company job postings efficiently</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('user.employer.web.job.create') }}"
               class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:-translate-y-1">
                + Create New Job
            </a>
            <a href="{{ route('user.employer.web.job.allPosts') }}"
               class="inline-block bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:-translate-y-1">
                View All Jobs
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($jobs->count())
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto rounded-lg shadow">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Department</th>
                        <th class="px-6 py-3">Employment Type</th>
                        <th class="px-6 py-3">Deadline</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @foreach ($jobs as $job)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $job->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->department }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->employment_type }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->application_deadline->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-2">
                                <a href="{{ route('user.employer.web.job.edit', $job) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow-sm transition transform hover:-translate-y-0.5">
                                    Edit
                                </a>
                                <form action="{{ route('user.employer.web.job.destroy', $job) }}" method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow-sm transition transform hover:-translate-y-0.5">
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
            @foreach ($jobs as $job)
                <div class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition transform hover:-translate-y-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                            <p class="text-gray-600 text-sm mt-1">Department: {{ $job->department }}</p>
                            <p class="text-gray-600 text-sm mt-1">Employment: {{ $job->employment_type }}</p>
                            <p class="text-gray-600 text-sm mt-1">Deadline: {{ $job->application_deadline->format('Y-m-d') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $job->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>

                    <div class="mt-4 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('user.employer.web.job.edit', $job) }}"
                           class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow transition transform hover:-translate-y-0.5">
                            Edit
                        </a>
                        <form action="{{ route('user.employer.web.job.destroy', $job) }}" method="POST" class="flex-1"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition transform hover:-translate-y-0.5">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500 text-center mt-8">No jobs found. Start by creating a new job posting.</p>
    @endif

</div>
@endsection
