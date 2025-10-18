@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Upload New Media</h2>

<form action="{{ route('user.Seller.product-media.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf

    <div>
        <label>Product</label>
        <select name="product_id" class="form-select w-full" required>
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label>Media File (Image or MP4)</label>
        <input type="file" name="media" accept="image/*,video/mp4" class="form-input w-full" required>
    </div>

    <button class="btn btn-primary">Upload</button>
</form>
@endsection
