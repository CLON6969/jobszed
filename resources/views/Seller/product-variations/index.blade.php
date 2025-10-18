@extends('layouts.seller')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Your Products</h1>
    <a href="{{ route('Seller.product-variations.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
        + Add Variation
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if($products->count())
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="p-3 text-left">Product Name</th>
                    <th class="p-3 text-left">Variations</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->variations_count }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('Seller.product-variations.show', $product->id) }}" 
                           class="text-blue-600 hover:underline">View Variations</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-gray-600">No products found.</p>
@endif
@endsection
