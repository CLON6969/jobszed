@extends('layouts.userjobs')

@section('title', 'Apply for ' . $job->title)

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            Apply for: {{ $job->title }}
        </h1>

        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Application Form --}}
        <form action="{{ route('user.applicant.jobs.apply.store', $job->slug) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf

            {{-- Upload CV --}}
            <div class="mb-6">
                <label for="cv" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Upload CV (PDF, DOC, DOCX) <span class="text-red-500">*</span>
                </label>
                <input
                    id="cv"
                    name="cv"
                    type="file"
                    accept=".pdf,.doc,.docx"
                    required
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-white 
                           bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-300 
                           dark:border-gray-600 cursor-pointer focus:outline-none"
                >
                @error('cv')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Cover Letter --}}
            <div class="mb-6">
                <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Cover Letter (optional)
                </label>
                <textarea
                    id="cover_letter"
                    name="cover_letter"
                    rows="6"
                    placeholder="Write a short cover letter..."
                    class="mt-1 block w-full rounded-lg border border-gray-300 
                           dark:border-gray-700 bg-gray-50 dark:bg-gray-700 
                           text-gray-900 dark:text-white shadow-sm 
                           focus:ring-indigo-500 focus:border-indigo-500"
                >{{ old('cover_letter') }}</textarea>

                @error('cover_letter')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Dynamic Job Questions --}}
            @if($job->questions && $job->questions->count())
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Job Questions</h2>
                @foreach($job->questions as $q)
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $q->question }} 
                            @if($q->required)<span class="text-red-500">*</span>@endif
                        </label>
                        <input
                            type="text"
                            name="answers[{{ $q->id }}]"
                            value="{{ old("answers.{$q->id}") }}"
                            class="mt-1 block w-full rounded-lg border border-gray-300 
                                   dark:border-gray-700 bg-gray-50 dark:bg-gray-700 
                                   text-gray-900 dark:text-white shadow-sm 
                                   focus:ring-indigo-500 focus:border-indigo-500"
                            @if($q->required) required @endif
                        >
                        @error("answers.{$q->id}")
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            @endif

            {{-- Submit Actions --}}
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('user.applicant.jobs.show', $job->slug) }}"
                   class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition">
                   ← Back to Job Details
                </a>

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
