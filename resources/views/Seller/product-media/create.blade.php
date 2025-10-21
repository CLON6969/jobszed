@extends('layouts.Seller')



@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Add Product Media</h2>

    @if ($errors->any())
        <div class="mb-6">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Seller.product-media.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Select Product</label>
            <select name="product_id" class="w-full border-gray-300 rounded-lg p-2" required>
                <option value="">Select Product</option>
                @foreach($SellerProducts as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        @include('Seller.product-media._form', ['buttonText' => 'Upload Media'])

    </form>
</div>
@endsection
