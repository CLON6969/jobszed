@extends('layouts.seller')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Edit Variation</h1>

<form action="{{ route('Seller.product-variations.update', $variation->id) }}" method="POST" 
      class="bg-white shadow rounded-lg p-6 max-w-2xl">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 mb-1">Variation Name</label>
            <input type="text" name="name" value="{{ $variation->name }}" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Option</label>
            <input type="text" name="option" value="{{ $variation->option }}" class="border rounded w-full p-2" required>
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Price Adjustment</label>
            <input type="number" step="0.01" name="price_adjustment" value="{{ $variation->price_adjustment }}" class="border rounded w-full p-2">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Stock</label>
            <input type="number" name="stock" value="{{ $variation->stock }}" class="border rounded w-full p-2" required>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('Seller.product-variations.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Cancel</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Update Variation
        </button>
    </div>
</form>
@endsection
