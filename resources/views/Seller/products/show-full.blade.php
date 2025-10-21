@extends('layouts.Seller')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-2xl shadow-md border border-gray-100">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $product->name }}</h2>

        <div class="flex gap-3">
            <a href="{{ route('Seller.products.edit', $product->id) }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
               Edit Product
            </a>
            <form method="POST" action="{{ route('Seller.products.destroy', $product->id) }}"
                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                  Delete
                </button>
            </form>
        </div>
    </div>

    {{-- MEDIA GALLERY --}}
    @if ($product->media->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
        @foreach ($product->media as $media)
        <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm">
            @if ($media->media_type === 'image')
                <img src="{{ asset('public/storage/' . $media->file_path) }}" alt="Product Image" class="w-full h-48 object-cover">
            @else
                <video controls class="w-full h-48 object-cover">
                    <source src="{{ asset('public/storage/' . $media->file_path) }}" type="video/mp4">
                </video>
            @endif
            @if ($media->is_primary)
            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded-md">
                Primary
            </span>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p class="text-gray-500 italic mb-8">No media uploaded for this product.</p>
    @endif

    {{-- PRODUCT DETAILS --}}
    <div class="grid md:grid-cols-2 gap-8 mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-3">Product Details</h3>
            <ul class="space-y-2 text-gray-700">
                <li><span class="font-medium">Category:</span> {{ $product->category->name ?? 'N/A' }}</li>
                <li><span class="font-medium">Price:</span> ZMW {{ number_format($product->price, 2) }}</li>
                <li><span class="font-medium">Condition:</span> {{ ucfirst($product->condition) }}</li>
                <li><span class="font-medium">Delivery Available:</span> {{ $product->delivery_available ? 'Yes' : 'No' }}</li>
                <li><span class="font-medium">Location:</span> {{ $product->location ?: 'Not specified' }}</li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
            <p class="text-gray-600 whitespace-pre-line">
                {{ $product->description ?: 'No description provided.' }}
            </p>
        </div>
    </div>

    {{-- VARIATIONS --}}
    @if ($product->variations->count() > 0)
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Product Variations</h3>
        <div class="overflow-x-auto border rounded-xl">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Option</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Price Adjustment (ZMW)</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($product->variations as $variation)
                    <tr>
                        <td class="px-4 py-2 text-gray-700">{{ $variation->name }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $variation->option ?: '-' }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ number_format($variation->price_adjustment, 2) }}</td>
                        <td class="px-4 py-2 text-gray-700">{{ $variation->stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- QUICK UPDATE FORM --}}
    <div class="mt-8 border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-3">Quick Update</h3>
        <form action="{{ route('Seller.products.quick-update', $product->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
            @csrf

            {{-- Status --}}
            <div>
                <label class="font-medium text-gray-600 text-sm">Status:</label>
                <select name="status" class="mt-1 border border-gray-300 rounded-md px-2 py-1 text-sm w-full @error('status') border-red-500 @enderror">
                    <option value="available" {{ $product->status === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold" {{ $product->status === 'sold' ? 'selected' : '' }}>Sold</option>
                    <option value="out_of_stock" {{ $product->status === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label class="font-medium text-gray-600 text-sm">Stock Quantity:</label>
                <input type="number" name="quantity" value="{{ $product->variations->sum('stock') }}" class="mt-1 border border-gray-300 rounded-md px-2 py-1 w-full  cursor-not-allowed @error('quantity') border-red-500 @enderror"   readonly>
                @error('quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            </div>
        </form>
        <p class="text-gray-500 text-sm mt-2">Stock is automatically calculated from product variations . when product is marked sold the quantity will be 0</p>
    </div>

    {{-- FOOTER --}}
    <div class="mt-8 flex justify-end">
        <a href="{{ route('Seller.products.index') }}" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            ← Back to Products
        </a>
    </div>
</div>
@endsection
