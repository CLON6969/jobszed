@extends('layouts.seller')

@section('content')
<h2 class="text-2xl font-semibold mb-4">My Products</h2>

<a href="{{ route('user.Seller.products.create') }}" class="btn btn-primary mb-4">Add Product</a>

<table class="table-auto w-full">
    <thead>
        <tr class="bg-gray-100">
            <th>Title</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ number_format($product->price, 2) }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->status ?? 'Active' }}</td>
            <td>
                <a href="{{ route('user.Seller.products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('user.Seller.products.destroy', $product) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}
@endsection
