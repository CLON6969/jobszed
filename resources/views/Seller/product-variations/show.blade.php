@extends('layouts.seller')

@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl">
    <h1 class="text-2xl font-semibold mb-4">Variation Details</h1>

    <div class="space-y-2">
        <p><strong class="text-gray-700">Product:</strong> {{ $variation->product->name ?? '-' }}</p>
        <p><strong class="text-gray-700">Variation Name:</strong> {{ $variation->name }}</p>
        <p><strong class="text-gray-700">Option:</strong> {{ $variation->option }}</p>
        <p><strong class="text-gray-700">Price Adjustment:</strong> {{ $variation->price_adjustment ?? 0 }}</p>
        <p><strong class="text-gray-700">Stock:</strong> {{ $variation->stock }}</p>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('Seller.product-variations.edit', $variation->id) }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('Seller.product-variations.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Back</a>
    </div>
</div>
@endsection
