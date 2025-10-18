@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Edit Media</h2>

<form action="{{ route('user.Seller.product-media.update', $productMedia) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Product</label>
        <select name="product_id" class="form-select w-full" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ $productMedia->product_id == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
