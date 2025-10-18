@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Add New Product</h2>

<form action="{{ route('user.Seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
        <label class="block font-medium">Title</label>
        <input type="text" name="title" class="form-input w-full" required>
    </div>

    <div>
        <label class="block font-medium">Description</label>
        <textarea name="description" class="form-textarea w-full"></textarea>
    </div>

    <div>
        <label class="block font-medium">Category</label>
        <select name="category_id" class="form-select w-full" required>
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Price</label>
            <input type="number" name="price" step="0.01" class="form-input w-full" required>
        </div>

        <div>
            <label class="block font-medium">Stock Quantity</label>
            <input type="number" name="stock" class="form-input w-full" required>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-medium">Condition</label>
            <input type="text" name="condition" class="form-input w-full">
        </div>

        <div>
            <label class="block font-medium">Location</label>
            <input type="text" name="location" class="form-input w-full">
        </div>
    </div>

    <div>
        <label class="block font-medium">Product Image</label>
        <input type="file" name="main_image" class="form-input">
    </div>

    <button type="submit" class="btn btn-primary">Create Product</button>
</form>
@endsection
