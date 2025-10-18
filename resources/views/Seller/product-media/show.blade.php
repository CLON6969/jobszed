@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-6">{{ $product->name }} - Media</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($product->media as $media)
            <div class="bg-white p-2 rounded shadow relative">
                @if($media->media_type == 'image')
                    <img src="{{ asset('public/storage/' . $media->file_path) }}" class="w-full h-48 object-cover rounded">
                @else
                    <video class="w-full h-48" controls>
                        <source src="{{ asset('public/storage/' . $media->file_path) }}" type="video/mp4">
                    </video>
                @endif
                @if($media->is_primary)
                    <span class="absolute top-1 left-1 bg-green-600 text-white text-xs px-2 py-1 rounded">Primary</span>
                @endif
            </div>
        @empty
            <p>No media found for this product.</p>
        @endforelse
    </div>

    <a href="{{ route('Seller.product-media.index') }}" class="mt-6 inline-block px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
</div>
@endsection
