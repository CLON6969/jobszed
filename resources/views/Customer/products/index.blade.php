@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    
    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-800 px-4 py-3 rounded mb-4">{{ session('info') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-4">
        <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}" class="border rounded px-3 py-2 w-32">
        <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}" class="border rounded px-3 py-2 w-32">
        <select name="category_id" class="border rounded px-3 py-2">
            <option value="">All Categories</option>
            @foreach(App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Status</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="sold" @selected(request('status') == 'sold')>Sold</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Filter</button>
    </form>

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition relative">
                @if($product->media->count())
                    <img src="{{ asset('storage/' . $product->media->first()->file_path) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                @else
                    <div class="h-48 w-full bg-gray-200 flex items-center justify-center">No Image</div>
                @endif
                <div class="p-4">
                    <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                    <p class="text-gray-600">{{ $product->category?->name }}</p>
                    <p class="text-blue-600 font-bold mt-2">${{ number_format($product->price, 2) }}</p>

                    {{-- Conditional Buttons --}}
                    <div class="mt-4 flex flex-col gap-2">
                        @auth
                            <form method="POST" action="{{ route('products.save', $product) }}">
                                @csrf
                                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition w-full">
                                    {{ Auth::user()->savedProducts()->where('product_id', $product->id)->exists() ? 'Saved' : 'Save' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('register') }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition w-full text-center">Sign up to Save</a>
                        @endauth

                        <a href="{{ route('Customer.products.show', $product) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition w-full text-center">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-600">No products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>
@endsection
