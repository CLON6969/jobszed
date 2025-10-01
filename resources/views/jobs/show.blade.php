
@extends('layouts.jobs')

@section('content')

<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Flash Messages -->
    @if (session('success'))
    <div class="max-w-4xl mx-auto mt-6 px-4 animate-fade-in">
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if (session('error'))
    <div class="max-w-4xl mx-auto mt-6 px-4">
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded relative">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Header -->
    <header data-aos="zoom-in" class="bg-white dark:bg-gray-800 shadow p-20 flex justify-between items-center ">
        <a href="{{ route('jobs.index') }}" class="text-indigo-900 dark:text-indigo-400 font-bold text-lg">← Back to Jobs</a>
        <button onclick="document.documentElement.classList.toggle('dark')" class="text-sm hover:text-indigo-600 text-gray-700 dark:text-gray-300"
        >
            <i class="fa-solid fa-moon"></i> Dark mode
        </button>
    </header>

    <!-- Main Job Card -->
    <main class="py-10 px-4 flex justify-center animate-fade-in">
        <div class="bg-white dark:bg-gray-800 w-full max-w-7xl rounded-xl shadow-lg p-8 border border-gray-200 dark:border-gray-700 space-y-8">

            <!-- Top Section -->
            <div class="flex flex-row sm:flex-row justify-between items-start sm:items-center gap-6">
                <div>
                    <p class="text-sm text-green-600 font-semibold uppercase mb-1">
                       <i class="fas fa-briefcase mr-2"></i>  {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                    </p>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                          {{ $job->title }}
                    </h2>
                    <p class="text-sm mt-1 text-gray-600 dark:text-gray-300">
                        <span class="font-semibold"><i class="fas fa-map-marker-alt mr-2 text-red-800"></i> Location:</span>
                        {{ $job->country ?? 'N/A' }},  {{ $job->location ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex flex-col items-end gap-3">
                    @if ($job->application_deadline->isFuture())
                        <a href="{{ auth()->check() ? route('jobs.apply', $job->slug) : route('register') }}"
                           class="bg-green-600 hover:bg-green-700 text-white text-sm px-6 py-2 rounded-lg font-semibold shadow transition">
                           <i class="fas fa-paper-plane mr-2"></i>
                           Apply
                        </a>
                    @else
                        <div class="text-red-600 text-sm font-semibold border border-red-300 bg-red-50 px-4 py-2 rounded-lg">
                            <i class="fas fa-lock mr-2"></i>
                            Applications Closed
                        </div>
                    @endif

                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}"
                         class="w-14 h-14 mt-2" alt="Company logo">
                </div>
            </div>

            <!-- Job Description -->
            <section  class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 shadow-inner animate-fade-in">
                <h3 class="text-lg font-semibold mb-3">
                    <i class="fas fa-align-left mr-2 text-black"></i>
                    Job Description </h3>
                <div class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                    {!! nl2br(e($job->description)) !!}
                </div>
            </section>

            <!-- Responsibilities -->
            @if ($job->responsibilities)
            <section class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 shadow-inner animate-fade-in">
                <h3 class="text-lg font-semibold mb-3">
                     <i class="fas fa-tasks mr-2 text-black"></i>
                     Responsibilities </h3>
                <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                    @foreach (explode(';', $job->responsibilities) as $item)
                        @if (trim($item))
                            <li>{{ trim($item) }}</li>
                        @endif
                    @endforeach
                </ul>
            </section>
            @endif

            <!-- Bottom Grid (Qualifications, Experience, Skills) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Qualifications -->
                @if ($job->qualifications->count())
                <section class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 shadow-inner animate-fade-in">
                    <h3 class="text-lg font-semibold mb-3">
                        <i class="fas fa-graduation-cap mr-2 text-black"></i>Qualifications </h3>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        @foreach ($job->qualifications as $q)
                            <li><i class="fas fa-check mr-2 text-green-400 font-bold"></i> {{ $q->title }} — {{ ucfirst($q->level) }}{{ $q->is_required ? ' (Required)' : '' }}</li>
                        @endforeach
                    </ul>
                </section>
                @endif

                <!-- Experience -->
                @if ($job->experiences->count())
                <section class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 shadow-inner animate-fade-in">
                    <h3 class="text-lg font-semibold mb-3">
                        <i class="fas fa-chart-line mr-2 text-black"></i>Experience </h3>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        @foreach ($job->experiences as $exp)
                            <li><i class="fas fa-check mr-2 text-green-400 font-bold"></i> {{ $exp->title }}{{ $exp->is_required ? ' (Required)' : '' }}</li>
                        @endforeach
                    </ul>
                </section>
                @endif

                <!-- Skills -->
                @if ($job->skills->count())
                <section class="bg-gray-50 dark:bg-gray-700 rounded-lg p-5 shadow-inner animate-fade-in">
                    <h3 class="text-lg font-semibold mb-3">
                        <i class="fas fa-tools mr-2 text-black"></i>Skills </h3>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        @foreach ($job->skills as $skill)
                            <li><i class="fas fa-check mr-2 text-green-400 font-bold"></i> {{ $skill->name }} ({{ ucfirst($skill->type) }}){{ $skill->is_required ? ' *' : '' }}</li>
                        @endforeach
                    </ul>
                </section>
                @endif
            </div>

        </div>
    </main>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>

@endsection
