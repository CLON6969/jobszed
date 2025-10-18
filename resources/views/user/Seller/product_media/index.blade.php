@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">Product Media</h2>

<a href="{{ route('user.Seller.product-media.create') }}" class="btn btn-primary mb-4">Upload New Media</a>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach ($media as $item)
        <div class="bg-white rounded-lg shadow p-3">
            @if(in_array($item->file_type, ['jpg', 'jpeg', 'png', 'webp']))
                <img src="{{ asset('storage/' . $item->file_path) }}" alt="Media" class="rounded-md w-full h-48 object-cover">
            @elseif($item->file_type === 'mp4')
                <video controls class="rounded-md w-full h-48">
                    <source src="{{ asset('storage/' . $item->file_path) }}" type="video/mp4">
                </video>
            @endif

            <div class="mt-2">
                <p class="text-sm text-gray-700"><strong>Product:</strong> {{ $item->product->name }}</p>
                <a href="{{ route('user.Seller.product-media.show', $item) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('user.Seller.product-media.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('user.Seller.product-media.destroy', $item) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this media?')">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $media->links() }}
</div>
@endsection
