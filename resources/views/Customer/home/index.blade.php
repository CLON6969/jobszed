@extends('layouts.Customer')

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-bounce">
        {{ session('error') }}
    </div>
@endif


<!-- HERO SECTION 
<section class="relative h-[20vh] flex items-center justify-center bg-gradient-to-r from-green-600 via--600 tgreeno-blue-400 text-white overflow-hidden">
    <img src="{{ asset('/public/uploads/pics/' . ($page->background_picture ?? 'default-bg.jpg')) }}" 
         alt="Background" 
         class="absolute inset-0 w-full h-full object-cover opacity-30">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-6" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight drop-shadow-lg">
            {{ $page->title1 ?? 'Our Products' }}
        </h1>
        <p class="mt-6 text-lg md:text-xl text-gray-200 leading-relaxed">
            {{ $page->title1_content ?? 'Explore the best products from verified sellers.' }}
        </p>
    </div>
</section>
-->

<!-- WELCOME HEADER -->
<header class="bg-white dark:bg-gray-900 shadow py-6">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <h2 class="text-2xl font-bold text-green-700 dark:text-blue-600" data-aos="fade-right">
            Browse <span class="text-gray-800 dark:text-white">Our Products</span>
        </h2>
        <button onclick="document.documentElement.classList.toggle('dark')" 
                class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 transition" data-aos="fade-left">
            <i class="fa-solid fa-moon"></i> Toggle Dark Mode
        </button>
    </div>
</header>



<!-- FILTER / SEARCH -->
<section class="py-10 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
    <form action="{{ route('Customer.home.index') }}" method="GET">
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-8 gap-6 px-6">

            <!-- Search -->
            <div class="col-span-2 relative" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-green-500"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search product name or keyword..."
                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 
                              bg-white  text-sm focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Category -->
            <select name="category"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white  text-sm focus:ring-2 focus:ring-indigo-500 w-full"
                    data-aos="fade-up" data-aos-delay="200">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @if(request('category')==$cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>

             <!-- status -->
            <select name="condition" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="">Condition</option>
                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
            </select>

            <!-- Location -->
            <select name="location"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white  text-sm focus:ring-2 focus:ring-indigo-500"
                    data-aos="fade-up" data-aos-delay="300">
                <option value="">All Locations</option>
                <option value="Lusaka" @if(request('location')=='Lusaka') selected @endif>Lusaka</option>
                <option value="Ndola" @if(request('location')=='Ndola') selected @endif>Ndola</option>
                <option value="Kitwe" @if(request('location')=='Kitwe') selected @endif>Kitwe</option>
            </select>

            <!-- Product Status -->
            <select name="status"
                    class="py-3 px-4 rounded-lg border border-gray-300 dark:border-gray-600 
                           bg-white  text-sm focus:ring-2 focus:ring-indigo-500"
                    data-aos="fade-up" data-aos-delay="400">
                <option value="">Status</option>
                <option value="active" @if(request('status')=='active') selected @endif>Active</option>
                <option value="inactive" @if(request('status')=='inactive') selected @endif>Inactive</option>
            </select>

            <!-- Submit -->
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow transition"
                    data-aos="fade-up" data-aos-delay="500">
                <i class="fas fa-search mr-2"></i> Search
            </button>

                    <a href="{{ route('Customer.home.index') }}" class="text-white bg-gray-600 text-center py-3 font-semibold hover:underline rounded-lg shadow transition hover:bg-gray-700">Reset</a>
        </div>
       
    </form>
</section>

<!-- PRODUCT LISTINGS --><!-- PRODUCT LISTINGS -->
<main class="py-16 bg-gray-100 dark:bg-gray-900">
    <div id="product-grid" class="max-w-8xl mx-auto grid gap-8 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 px-6">

     @foreach ($products as $product)
    @php
        $seller = $product->seller ?? null;
        $sellerProfile = $seller && $seller->profile_picture 
            ? asset('public/storage/' . $seller->profile_picture)
            : asset('public/uploads/pics/logo1.png');
        $sellerName = $seller && $seller->name ? $seller->name : 'Unknown Seller';

        $productImage = $product->media && $product->media->first()
            ? asset('public/storage/' . $product->media->first()->file_path)
            : asset('public/uploads/pics/default-product.png');
    @endphp

    <a href="{{ route('Customer.home.show', $product->id) }}"
       class="product-card block bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 
              rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:border-indigo-600 dark:hover:border-white">

        <!-- Product Image -->
        <div class="relative w-full h-56 overflow-hidden rounded-t-2xl">
            <img src="{{ $productImage }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform hover:scale-105">
        </div>

        <div class="p-6 space-y-4">
            <!-- Header: Seller Info -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ $sellerProfile }}" 
                         alt="Seller Logo"
                         class="w-14 h-14 rounded-full object-cover border-2 border-indigo-500 shadow-sm">

                    <div class="flex flex-col">
                        <h4 class="font-semibold text-gray-900 dark:text-white text-lg leading-tight">
                            {{ $sellerName }}
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $product->category->name ?? 'General Category' }}
                        </p>
                    </div>
                </div>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="fa-regular fa-clock mr-1 text-indigo-500"></i>
                    {{ $product->created_at ? $product->created_at->diffForHumans() : '—' }}
                </div>
            </div>

            <!-- Product Content -->
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-snug hover:text-indigo-600 transition">
                {{ $product->name }}
            </h3>
            <p class="text-base text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                {{ Str::limit(strip_tags($product->description), 200) }}
            </p>
            <p class="font-semibold text-indigo-600 dark:text-indigo-400">K{{ number_format($product->price,2) }}</p>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 mt-2 text-sm text-gray-600 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-indigo-500"></i>
                    <span>{{ $product->location ?? 'Location not specified' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-box text-green-600"></i>
                    <span>{{ ucfirst($product->status ?? 'N/A') }}</span>
                </div>
            </div>

            <!-- Footer -->
            <div class="pt-4 flex justify-between items-center border-t border-gray-100 dark:border-gray-700 mt-4">
                <span class="px-4 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 
                             dark:bg-indigo-700 dark:text-indigo-100">
                    {{ ucfirst($product->status ?? 'N/A') }}
                </span>

                <button class="px-6 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg 
                               hover:bg-indigo-700 shadow-md hover:shadow-lg transition-all duration-300">
                    View Details →
                </button>
            </div>
        </div>
    </a>
@endforeach

        @if($products->isEmpty())
            <p class="text-gray-600 dark:text-gray-300 text-center col-span-full" data-aos="fade-up">
                No products available at the moment.
            </p>
        @endif
    </div>

    <!-- Pagination Controls -->
    <div id="pagination-wrapper" class="flex justify-center items-center gap-2 mt-8"></div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const productContainer = document.getElementById("product-grid");
    const products = Array.from(productContainer.getElementsByClassName("product-card"));
    const perPage = 10;
    let currentPage = 1;
    const totalPages = Math.ceil(products.length / perPage);

    const paginationWrapper = document.getElementById("pagination-wrapper");

    function renderPage(page) {
        products.forEach((product, index) => {
            product.style.display =
                index >= (page - 1) * perPage && index < page * perPage
                    ? "block"
                    : "none";
        });

        // Clear previous pagination buttons
        paginationWrapper.innerHTML = "";

        // Prev button
        const prevBtn = document.createElement("button");
        prevBtn.textContent = "Prev";
        prevBtn.disabled = page === 1;
        prevBtn.className = "px-3 py-1 bg-gray-200 rounded disabled:opacity-50";
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
        nextBtn.disabled = page === totalPages;
        nextBtn.className = "px-3 py-1 bg-gray-200 rounded disabled:opacity-50";
        nextBtn.onclick = () => { currentPage++; renderPage(currentPage); };
        paginationWrapper.appendChild(nextBtn);
    }

    if (products.length > 0) renderPage(currentPage);
});
</script>

<script>
    setTimeout(() => {
        const messages = document.querySelectorAll('.fixed.top-5');
        messages.forEach(msg => msg.remove());
    }, 5000); // 5 seconds
</script>


<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>



@endsection
