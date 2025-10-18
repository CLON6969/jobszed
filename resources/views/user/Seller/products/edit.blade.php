@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Product</h2>

<form action="{{ route('user.Seller.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium">Title</label>
        <input type="text" name="title" value="{{ old('title', $product->title) }}" class="form-input w-full" required>
    </div>

    <div>
        <label class="block font-medium">Description</label>
        <textarea name="description" class="form-textarea w-full">{{ old('description', $product->description) }}</textarea>
    </div>

    <div>
        <label class="block font-medium">Category</label>
        <select name="category_id" class="form-select w-full" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected':'' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Price</label>
            <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-medium">Stock Quantity</label>
            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="form-input w-full" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Condition</label>
            <input type="text" name="condition" value="{{ old('condition', $product->condition) }}" class="form-input w-full">
        </div>

        <div>
            <label class="block font-medium">Location</label>
            <input type="text" name="location" value="{{ old('location', $product->location) }}" class="form-input w-full">
        </div>
    </div>

    <div>
        <label class="block font-medium">Product Image</label>
        @if($product->main_image)
            <img src="{{ asset('storage/'.$product->main_image) }}" alt="Product Image" class="w-24 h-24 object-cover mb-2">
        @endif
        <input type="file" name="main_image" class="form-input">
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
</form>
@endsection
