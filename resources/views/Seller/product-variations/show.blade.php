@extends('layouts.seller')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Variations for {{ $product->name }}</h1>

@if($product->variations->count())
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="p-3 text-left">Variation Name</th>
                    <th class="p-3 text-left">Option</th>
                    <th class="p-3 text-left">Price Adjustment</th>
                    <th class="p-3 text-left">Stock</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->variations as $variation)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $variation->name }}</td>
                    <td class="p-3">{{ $variation->option }}</td>
                    <td class="p-3">{{ $variation->price_adjustment ?? 0 }}</td>
                    <td class="p-3">{{ $variation->stock }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('Seller.product-variations.edit', $variation->id) }}" 
                           class="text-yellow-600 hover:underline">Edit</a>
                        <form action="{{ route('Seller.product-variations.destroy', $variation->id) }}" 
                              method="POST" onsubmit="return confirm('Delete this variation?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-gray-600">No variations found for this product.</p>
@endif

<div class="mt-6 flex justify-start gap-3">
    <a href="{{ route('Seller.product-variations.index') }}" 
       class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">← Back to Products</a>
</div>
@endsection
