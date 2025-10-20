@extends('layouts.Customer') {{-- Assuming you have a Customer layout --}}

@section('title', 'My Saved Products')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">My Saved Products</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($saved->isEmpty())
        <p class="text-gray-600">You have no saved products yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($saved as $product)
                <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition duration-200">
                    {{-- Product Image --}}
                    @if($product->media->where('is_primary', true)->first())
                        <img src="{{ asset('public/storage/' . $product->media->where('is_primary', true)->first()->file_path) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" alt="No image"
                             class="w-full h-48 object-cover">
                    @endif

                    {{-- Product Details --}}
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2">
                            <a href="{{ route('Customer.home.show', $product->id) }}" class="hover:underline">
                                {{ $product->name }}
                            </a>
                        </h2>

                        <p class="text-gray-600 mb-2">Price: ${{ number_format($product->price, 2) }}</p>
                        <p class="text-gray-500 text-sm mb-4">{{ Str::limit($product->description, 60) }}</p>

                        {{-- Remove button --}}
                        <form action="{{ route('Customer.saved.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
