
@extends('layouts.userjobs')

@section('content')
<Style>
    
/* HERO SECTION */
.hero {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 70vh;
    position: relative;
    overflow: hidden;
    
}

.hero img {
right: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    flex-shrink: 0;
    
}

.hero h1 {
font-size: 18px;
font-weight: 700;
}

/* Overlay Effect */
.overlay {
    background: rgba(0, 0, 0, 0.352); /* Dark overlay */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: start;
    color: white;
    padding: 20px;
    position: absolute;
    inset: 0; /* Covers the entire hero section */
}

.overlay-content{
    width: 60%;
    padding-left: 45px;
}

/* Buttons */
.buttons {
margin-top: 20px;
padding-left: 40px;
}

.buttons .btn {
    background: #fff;
    color: #000;
    padding: 10px 20px;
    border: none;
    margin: 10px;
    cursor: pointer;
    font-size: 16px;
}

.buttons .btn:hover {
    background: #000000;
    color: #ffffff;
    border: 2px solid rgb(108, 106, 106);
}


.btn.secondary {
    background: black;
    color: #fff;
    border: 2px solid white;
}

.btn.secondary:hover {
    background: rgb(255, 255, 255);
    color: #000000;
    border: 2px solid rgb(133, 133, 133);
}

</Style>





    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-extrabold text-indigo-700 dark:text-indigo-400">Career<span class="text-gray-800 dark:text-white">s</span></h1>
        <button onclick="document.documentElement.classList.toggle('dark')" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600">
        <i class="fa-solid fa-moon"></i> Dark Mode
        </button>
    </header>

    <!-- Filter/Search Section -->
   <section class="py-6 px-4 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
  <form action="{{ route('jobs.index') }}" method="GET">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-5 gap-4">

        <!-- Search -->
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-indigo-500"></i>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search job title..."
                class="pl-10 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md w-full text-sm"
            />
        </div>

        <!-- Category -->
        <div class="relative">
            <i class="fas fa-folder-open absolute left-3 top-1/2 transform -translate-y-1/2 text-yellow-500"></i>
            <select name="category" class="pl-10 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md w-full text-sm">
                <option value="">All Categories</option>
                <option value="IT" @if(request('category') == 'IT') selected @endif>IT</option>
                <option value="Finance" @if(request('category') == 'Finance') selected @endif>Finance</option>
                <option value="Education" @if(request('category') == 'Education') selected @endif>Education</option>
            </select>
        </div>

        <!-- Location -->
        <div class="relative">
            <i class="fas fa-map-marker-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-red-800"></i>
            <select name="location" class="pl-10 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md w-full text-sm">
                <option value="">All Locations</option>
                <option value="Lusaka" @if(request('location') == 'Lusaka') selected @endif>Lusaka</option>
                <option value="Ndola" @if(request('location') == 'Ndola') selected @endif>Ndola</option>
                <option value="Kitwe" @if(request('location') == 'Kitwe') selected @endif>Kitwe</option>
            </select>
        </div>

        <!-- Job Type -->
        <div class="relative">
            <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500"></i>
            <select name="employment_type" class="pl-10 p-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md w-full text-sm">
                <option value="">Job Type</option>
                <option value="full_time" @if(request('employment_type') == 'full_time') selected @endif>Full-time</option>
                <option value="part_time" @if(request('employment_type') == 'part_time') selected @endif>Part-time</option>
                <option value="contract" @if(request('employment_type') == 'contract') selected @endif>Contract</option>
                <option value="internship" @if(request('employment_type') == 'internship') selected @endif>Internship</option>
            </select>

            
        </div>


       
        <!-- Submit -->
        <button type="submit" class="bg-indigo-600 text-white rounded-md px-4 py-2 hover:bg-indigo-700 transition flex items-center justify-center">
            <i class="fas fa-search mr-2 text-white"></i> Search
        </button>
        

    </div>
</form>

</section>


    <!-- Job Listings -->
<main class="flex-grow p-10 bg-gray-100 dark:bg-gray-900 transition-all">
    <div class="max-w-7xl mx-auto grid gap-10 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 animate-fade-in">

        @foreach ($jobs as $job)
            <a href="{{ route('user.applicant.jobs.show', $job->slug) }}" class="relative block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl px-8 py-10 min-h-[360px] w-full hover:shadow-2xl transition-all">

                <!-- Icon (Top Left) -->
                <div class="absolute top-6 left-6">
                    <img src="{{ asset('/public/uploads/pics/' . $logo->picture) }}" class="w-12 h-12" alt="logo">
                </div>

                <!-- Location (Top Right) -->
                <div class="absolute top-6 right-6 text-sm text-gray-700 dark:text-gray-300 text-right">
                    <div><span class="font-semibold">Location:</span></div>
                    <div>{{ $job->country ?? 'N/A' }}, {{ $job->location ?? 'N/A' }}</div>
                </div>

                <!-- Job Content Section -->
                <div class="mt-28 space-y-4">
                    <!-- Title & Verified -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $job->title }}</h2>
                        <span class="text-xs bg-blue-500 text-white px-3 py-0.5 rounded-full border border-blue-700">
                            verified
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ Str::limit(strip_tags($job->description), 200) }}
                    </p>

                    <!-- Footer Details: Deadline + Type -->
                    <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-400">
                        <div>
                            Closing: <strong>{{ \Carbon\Carbon::parse($job->application_deadline)->format('d/m/Y') }}</strong>
                        </div>
                        <div class="font-semibold">
                            {{ ucfirst(str_replace('_', ' ', $job->employment_type)) }}
                        </div>
                    </div>

                    <!-- Status + Apply Button -->
                    <div class="flex justify-between items-center pt-2">
                        <span class="bg-green-600 text-white text-xs px-4 py-1 rounded-full shadow">
                            {{ $job->status }}
                        </span>
                        <span class="bg-black text-white text-sm font-semibold px-6 py-2 rounded shadow">
                           Read more
                        </span>
                    </div>
                </div>
            </a>
        @endforeach

        @if($jobs->isEmpty())
            <p class="text-gray-600 dark:text-gray-300 text-center col-span-full">No jobs available at the moment.</p>
        @endif

    </div>
</main>


    <!-- script for fading in -->
 <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out both;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection