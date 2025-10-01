@extends('layouts.jobs')

@section('content')

<!-- HERO SECTION -->
<section class="relative h-[45vh] flex items-center justify-center bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
    <img src="{{ asset('/public/uploads/pics/' . $job_page->background_picture) }}" 
         alt="Background" 
         class="absolute inset-0 w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-6" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight drop-shadow-lg">
            {{ $job_page->title1 }}
        </h1>
        <p class="mt-6 text-lg md:text-xl text-gray-200 leading-relaxed">
            {{ $job_page->title1_content }}
        </p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ $job_page->button1_url }}" 
               class="px-6 py-3 rounded-lg bg-white text-indigo-700 font-semibold shadow hover:bg-indigo-50 transition" data-aos="zoom-in">
                {{ $job_page->button1_name }} →
            </a>
            <a href="{{ $job_page->button2_url }}" 
               class="px-6 py-3 rounded-lg border-2 border-white text-white font-semibold shadow hover:bg-white hover:text-indigo-700 transition" data-aos="zoom-in" data-aos-delay="200">
                {{ $job_page->button2_name }} →
            </a>
        </div>
    </div>
</section>

<!-- WELCOME HEADER -->
<header class="bg-white dark:bg-gray-900 shadow py-6">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-2xl font-bold text-indigo-700 dark:text-indigo-400" data-aos="fade-right">
            Find Your <span class="text-gray-800 dark:text-white">Next Career Move</span>
        </h2>
        <button onclick="document.documentElement.classList.toggle('dark')" 
                class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition" data-aos="fade-left">
            <i class="fa-solid fa-moon"></i> Toggle Dark Mode
        </button>
    </div>
</header>

<!-- FILTER / SEARCH -->
<section class="py-10 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
    <form action="{{ route('jobs.index') }}" method="GET">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-6 gap-6 px-6">

            <!-- Search -->
            <div class="col-span-2 relative" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-indigo-500"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search job title or keyword..."
                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 
                              bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Category -->
            <select name="category"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-indigo-500"
                    data-aos="fade-up" data-aos-delay="200">
                <option value="">All Categories</option>
                <option value="IT" @if(request('category') == 'IT') selected @endif>IT</option>
                <option value="Finance" @if(request('category') == 'Finance') selected @endif>Finance</option>
                <option value="Education" @if(request('category') == 'Education') selected @endif>Education</option>
            </select>

            <!-- Location -->
            <select name="location"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-indigo-500"
                    data-aos="fade-up" data-aos-delay="300">
                <option value="">All Locations</option>
                <option value="Lusaka" @if(request('location') == 'Lusaka') selected @endif>Lusaka</option>
                <option value="Ndola" @if(request('location') == 'Ndola') selected @endif>Ndola</option>
                <option value="Kitwe" @if(request('location') == 'Kitwe') selected @endif>Kitwe</option>
            </select>

            <!-- Job Type -->
            <select name="employment_type"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-indigo-500"
                    data-aos="fade-up" data-aos-delay="400">
                <option value="">Job Type</option>
                <option value="full_time" @if(request('employment_type') == 'full_time') selected @endif>Full-time</option>
                <option value="part_time" @if(request('employment_type') == 'part_time') selected @endif>Part-time</option>
                <option value="contract" @if(request('employment_type') == 'contract') selected @endif>Contract</option>
                <option value="internship" @if(request('employment_type') == 'internship') selected @endif>Internship</option>
            </select>

            <!-- Submit -->
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow transition"
                    data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </div>
    </form>
</section>

<!-- JOB LISTINGS -->
<main class="py-16 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 px-6">

        @foreach ($jobs as $job)
            <a href="{{ route('jobs.show', $job->slug) }}"
               class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition p-6 flex flex-col justify-between"
               data-aos="fade-up" data-aos-duration="800">

                <!-- Top: Logo & Location -->
                <div class="flex justify-between items-start">
                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" 
                         class="w-12 h-12 rounded-md" alt="logo">

                    <div class="text-right text-sm text-gray-600 dark:text-gray-400">
                        <p class="font-semibold">{{ $job->country ?? 'N/A' }}</p>
                        <p>{{ $job->location ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Job Info -->
                <div class="mt-6 space-y-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $job->title }}
                    </h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                        {{ Str::limit(strip_tags($job->description), 150) }}
                    </p>
                </div>

                <!-- Footer -->
                <div class="mt-6 flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
                    <span class="bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100 px-3 py-1 rounded-full text-xs font-medium">
                        {{ ucfirst($job->status) }}
                    </span>
                    <span class="font-semibold">
                        {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                    </span>
                </div>

                <div class="mt-4">
                    <button class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                        View Details →
                    </button>
                </div>
            </a>
        @endforeach

        @if($jobs->isEmpty())
            <p class="text-gray-600 dark:text-gray-300 text-center col-span-full" data-aos="fade-up">
                No jobs available at the moment. Check back soon!
            </p>
        @endif
    </div>
</main>

<!-- this is for next page when posts reach 20 -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const jobContainer = document.querySelector("main > div"); // The grid container
    const jobs = Array.from(jobContainer.querySelectorAll("a")); // All job cards
    const perPage = 20; // Jobs per page
    let currentPage = 1;
    const totalPages = Math.ceil(jobs.length / perPage);

    // Create pagination wrapper
    const paginationWrapper = document.createElement("div");
    paginationWrapper.className = "flex justify-center items-center gap-2 mt-8";
    jobContainer.parentNode.appendChild(paginationWrapper);

    function renderPage(page) {
        jobs.forEach((job, index) => {
            job.style.display =
                index >= (page - 1) * perPage && index < page * perPage
                    ? "block"
                    : "none";
        });

        // Clear previous pagination
        paginationWrapper.innerHTML = "";

        // Prev button
        const prevBtn = document.createElement("button");
        prevBtn.textContent = "Prev";
        prevBtn.className = "px-3 py-1 bg-gray-200 rounded disabled:opacity-50";
        prevBtn.disabled = page === 1;
        prevBtn.onclick = () => { currentPage--; renderPage(currentPage); };
        paginationWrapper.appendChild(prevBtn);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement("button");
            pageBtn.textContent = i;
            pageBtn.className = "px-3 py-1 rounded " + (i === page ? "bg-indigo-600 text-white" : "bg-gray-200");
            pageBtn.onclick = () => { currentPage = i; renderPage(currentPage); };
            paginationWrapper.appendChild(pageBtn);
        }

        // Next button
        const nextBtn = document.createElement("button");
        nextBtn.textContent = "Next";
        nextBtn.className = "px-3 py-1 bg-gray-200 rounded disabled:opacity-50";
        nextBtn.disabled = page === totalPages;
        nextBtn.onclick = () => { currentPage++; renderPage(currentPage); };
        paginationWrapper.appendChild(nextBtn);
    }

    if (jobs.length > 0) renderPage(currentPage);
});
</script>

<!-- AOS Library for Scroll Animations -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

@endsection

@php 
    $logo = App\Models\Logo::first();
@endphp
