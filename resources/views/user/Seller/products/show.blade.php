@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">{{ $product->title }}</h2>

<div class="grid grid-cols-2 gap-6">
    <div>
        @if($product->main_image)
            <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->title }}" class="rounded-lg w-full h-80 object-cover">
        @else
            <div class="bg-gray-100 p-10 text-center text-gray-500">No Image Available</div>
        @endif
    </div>

    <div>
        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        <p><strong>Stock:</strong> {{ $product->stock }}</p>
        <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
        <p><strong>Condition:</strong> {{ $product->condition ?? 'N/A' }}</p>
        <p><strong>Location:</strong> {{ $product->location ?? 'N/A' }}</p>
        <p><strong>Description:</strong></p>
        <p>{{ $product->description ?? 'No description provided.' }}</p>

        <div class="mt-6">
            <a href="{{ route('user.Seller.products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('user.Seller.products.destroy', $product) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
