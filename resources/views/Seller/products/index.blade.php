@extends('layouts.seller')

@section('title', 'My Products')

@section('content')
<div class="container mx-auto py-8 px-4">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-800">My Products</h1>
        <a href="{{ route('Seller.products.create') }}" 
           class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
            + Add Product
        </a>
    </div>

    {{-- FILTER BAR --}}
    <form method="GET" action="{{ route('Seller.products.index') }}" 
          class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 grid grid-cols-1 md:grid-cols-6 gap-4">
        
        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
            class="col-span-2 border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

        <select name="category" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="condition" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500">
            <option value="">Condition</option>
            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New</option>
            <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used</option>
        </select>

        <select name="status" class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500">
            <option value="">Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
            Filter
        </button>

        <a href="{{ route('Seller.products.index') }}" 
           class="text-gray-600 text-center py-2 hover:underline">Reset</a>
    </form>

    @if(session('duplicate') && session('product_id'))
    <script>
        const productId = "{{ session('product_id') }}";
        const existingProduct = document.getElementById('product-row-' + productId);
        if (existingProduct) {
            existingProduct.classList.add('highlight');
            alert('This product already exists!');
        }
    </script>
@endif


    {{-- PRODUCT GRID/LIST --}}
    @if($products->count())
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-0 divide-y sm:divide-y-0 sm:divide-x">
                @foreach($products as $product)
                    <div class="group flex flex-col sm:flex-row sm:items-center p-4 hover:bg-gray-50 transition">
                        
                        {{-- Product Thumbnail --}}
                        <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden bg-gray-100">
                            @if($product->media->count())
                                <img src="{{ asset('public/storage/'.$product->media->first()->file_path) }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                    No image
                                </div>
                            @endif
                        </div>

                        {{-- Product Info --}}
                        <div class="flex-1 sm:ml-4 mt-3 sm:mt-0">
                            <h3 class="text-gray-800 font-medium group-hover:text-blue-600 transition">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-gray-500">{{ $product->category->name ?? '—' }}</p>
                            <p class="text-gray-800 font-semibold mt-1">ZMW {{ number_format($product->price, 2) }}</p>
                            <p class="text-xs text-gray-500">Stock: {{ $product->stock_quantity }} | {{ ucfirst($product->condition) }}</p>

                            {{-- Action Buttons --}}
                            <div class="mt-2 flex gap-3 text-sm">
                                <a href="{{ route('Seller.products.show', $product->id) }}" class="text-blue-600 hover:underline">View</a>
                                <a href="{{ route('Seller.products.edit', $product->id) }}" class="text-yellow-600 hover:underline">Edit</a>
                                <form action="{{ route('Seller.products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this product?')" class="text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @else
        <p class="text-gray-600 mt-8 text-center">No products yet. 
            <a href="{{ route('Seller.products.create') }}" class="text-blue-600 underline">Add one</a>.
        </p>
    @endif
</div>
@endsection
