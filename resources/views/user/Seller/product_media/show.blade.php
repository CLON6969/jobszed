@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Media Details</h2>

<div class="bg-white shadow p-6 rounded-lg">
    <p><strong>Product:</strong> {{ $productMedia->product->name }}</p>

    <div class="mt-3">
        @if(in_array($productMedia->file_type, ['jpg', 'jpeg', 'png', 'webp']))
            <img src="{{ asset('storage/' . $productMedia->file_path) }}" alt="Media" class="rounded-md w-full h-64 object-cover">
        @elseif($productMedia->file_type === 'mp4')
            <video controls class="rounded-md w-full h-64">
                <source src="{{ asset('storage/' . $productMedia->file_path) }}" type="video/mp4">
            </video>
        @endif
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('user.Seller.product-media.edit', $productMedia) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('user.Seller.product-media.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
