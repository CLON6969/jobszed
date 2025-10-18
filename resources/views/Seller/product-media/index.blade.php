@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Product Media</h2>
        <a href="{{ route('Seller.product-media.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Add Media</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="bg-white shadow rounded p-4">
            <div class="h-48 mb-2 overflow-hidden rounded">
                @if($product->media->first())
                    @if($product->media->first()->media_type == 'image')
                        <img src="{{ asset('public/storage/' . $product->media->first()->file_path) }}" class="w-full h-full object-cover">
                    @else
                        <video class="w-full h-full" controls>
                            <source src="{{ asset('public/storage/' . $product->media->first()->file_path) }}" type="video/mp4">
                        </video>
                    @endif
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">No media</div>
                @endif
            </div>
            <h3 class="font-semibold text-lg">{{ $product->name }}</h3>
            <div class="mt-2 flex justify-between">
                <a href="{{ route('Seller.product-media.show', $product->id) }}" class="text-blue-600 hover:underline">View</a>
                <a href="{{ route('Seller.product-media.edit', $product->id) }}" class="text-yellow-600 hover:underline">Edit</a>
            </div>
        </div>
        @empty
        <p>No products found.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
