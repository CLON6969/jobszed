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
           bg-white dark:bg-gray-700 text-sm focus:ring-2 focus:ring-indigo-500 w-full"
    data-aos="fade-up" data-aos-delay="200">

    <option value="">All Categories</option>

    <option value="Information Technology" @if(request('category') == 'Information Technology') selected @endif>Information Technology</option>
    <option value="Finance & Accounting" @if(request('category') == 'Finance & Accounting') selected @endif>Finance & Accounting</option>
    <option value="Education & Training" @if(request('category') == 'Education & Training') selected @endif>Education & Training</option>
    <option value="Healthcare & Medical" @if(request('category') == 'Healthcare & Medical') selected @endif>Healthcare & Medical</option>
    <option value="Engineering & Technical" @if(request('category') == 'Engineering & Technical') selected @endif>Engineering & Technical</option>
    <option value="Sales & Marketing" @if(request('category') == 'Sales & Marketing') selected @endif>Sales & Marketing</option>
    <option value="Customer Service & Support" @if(request('category') == 'Customer Service & Support') selected @endif>Customer Service & Support</option>
    <option value="Administration & Office Support" @if(request('category') == 'Administration & Office Support') selected @endif>Administration & Office Support</option>
    <option value="Human Resources" @if(request('category') == 'Human Resources') selected @endif>Human Resources</option>
    <option value="Construction & Property" @if(request('category') == 'Construction & Property') selected @endif>Construction & Property</option>
    <option value="Transport & Logistics" @if(request('category') == 'Transport & Logistics') selected @endif>Transport & Logistics</option>
    <option value="Manufacturing & Production" @if(request('category') == 'Manufacturing & Production') selected @endif>Manufacturing & Production</option>
    <option value="Agriculture & Farming" @if(request('category') == 'Agriculture & Farming') selected @endif>Agriculture & Farming</option>
    <option value="Legal & Compliance" @if(request('category') == 'Legal & Compliance') selected @endif>Legal & Compliance</option>
    <option value="Media & Communications" @if(request('category') == 'Media & Communications') selected @endif>Media & Communications</option>
    <option value="Design, Arts & Creative" @if(request('category') == 'Design, Arts & Creative') selected @endif>Design, Arts & Creative</option>
    <option value="Hospitality & Tourism" @if(request('category') == 'Hospitality & Tourism') selected @endif>Hospitality & Tourism</option>
    <option value="Retail & Consumer Services" @if(request('category') == 'Retail & Consumer Services') selected @endif>Retail & Consumer Services</option>
    <option value="Nonprofit & NGO" @if(request('category') == 'Nonprofit & NGO') selected @endif>Nonprofit & NGO</option>
    <option value="Government & Public Sector" @if(request('category') == 'Government & Public Sector') selected @endif>Government & Public Sector</option>
    <option value="Science & Research" @if(request('category') == 'Science & Research') selected @endif>Science & Research</option>
    <option value="Security & Defence" @if(request('category') == 'Security & Defence') selected @endif>Security & Defence</option>
    <option value="Real Estate" @if(request('category') == 'Real Estate') selected @endif>Real Estate</option>
    <option value="Energy & Environment" @if(request('category') == 'Energy & Environment') selected @endif>Energy & Environment</option>
    <option value="Sports & Recreation" @if(request('category') == 'Sports & Recreation') selected @endif>Sports & Recreation</option>
    <option value="Telecommunications" @if(request('category') == 'Telecommunications') selected @endif>Telecommunications</option>
    <option value="Others" @if(request('category') == 'Others') selected @endif>Others</option>
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
    <div class="max-w-8xl mx-auto grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 px-6">

     @foreach ($jobs as $job)
    @php
        // Poster (relationship)
        $poster = $job->user ?? $job->employer ?? $job->poster ?? null;

        // Profile picture & name
        $posterProfile = $poster && $poster->profile_picture 
            ? asset('public/storage/' . $poster->profile_picture)
            : asset('public/uploads/pics/logo1.png');

        $posterName = $poster && $poster->name ? $poster->name : 'Unknown Employer';
    @endphp

    <a href="{{ route('jobs.show', $job->slug) }}"
       class="block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 
              rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 
              p-8 space-y-6 hover:border-indigo-400">

        <!-- Header: Employer Info -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ $posterProfile }}" 
                     alt="Employer Logo"
                     class="w-14 h-14 rounded-full object-cover border-2 border-indigo-500 shadow-sm">

                <div class="flex flex-col">
                    <h4 class="font-semibold text-gray-900 dark:text-white text-lg leading-tight">
                        {{ $posterName }}
                    </h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $job->department ?? 'General Department' }}
                    </p>
                </div>
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fa-regular fa-clock mr-1 text-indigo-500"></i>
                {{ $job->created_at ? $job->created_at->diffForHumans() : '—' }}
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-gray-100 dark:border-gray-700">

        <!-- Job Content -->
        <div class="space-y-3">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-snug hover:text-indigo-600 transition">
                {{ $job->title }}
            </h3>
            <p class="text-base text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                {{ Str::limit(strip_tags($job->description), 200) }}
            </p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 mt-4 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-indigo-500"></i>
                <span>{{ $job->location ?? 'Location not specified' }}</span>
            </div>

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-hourglass-end text-pink-500"></i>
                <span>Deadline: {{ $job->application_deadline ? $job->application_deadline->format('M d, Y') : 'N/A' }}</span>
            </div>

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-amber-500"></i>
                <span>{{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}</span>
            </div>

            <div class="flex items-center gap-2">
                <i class="fa-solid fa-flag text-green-600"></i>
                <span>Status: 
                    <span class="{{ $job->status == 'open' 
                        ? 'text-green-700 dark:text-green-400' 
                        : 'text-red-700 dark:text-red-400' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-6 flex justify-between items-center border-t border-gray-100 dark:border-gray-700 mt-4">
            <div class="flex gap-3">
                <span class="px-4 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 
                            dark:bg-indigo-700 dark:text-indigo-100">
                    {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                </span>
                <span class="px-4 py-1 rounded-full text-xs font-medium 
                            {{ $job->status == 'open' 
                                ? 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100' 
                                : 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100' }}">
                    {{ ucfirst($job->status) }}
                </span>
            </div>

            <button class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg 
                           hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-300">
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
