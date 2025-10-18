@extends('layouts.seller')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Product Variations</h1>
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

@if($variations->count())
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Option</th>
                    <th class="p-3 text-left">Price Adjustment</th>
                    <th class="p-3 text-left">Stock</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($variations as $variation)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">{{ $variation->product->name ?? '-' }}</td>
                    <td class="p-3">{{ $variation->name }}</td>
                    <td class="p-3">{{ $variation->option }}</td>
                    <td class="p-3">{{ $variation->price_adjustment ?? 0 }}</td>
                    <td class="p-3">{{ $variation->stock }}</td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('Seller.product-variations.show', $variation->id) }}" 
                           class="text-blue-600 hover:underline">View</a>
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

    <div class="mt-4">
        {{ $variations->links() }}
    </div>
@else
    <p class="text-gray-600">No variations found.</p>
@endif
@endsection
