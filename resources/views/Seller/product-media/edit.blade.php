@extends('layouts.seller')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-md border border-gray-100">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Edit Media for: {{ $product->name }}</h2>

    @if ($errors->any())
        <div class="mb-6">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Seller.product-media.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('Seller.product-media._form', ['buttonText' => 'Update Media', 'product' => $product])

    </form>
</div>
@endsection


