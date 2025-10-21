@extends('layouts.Seller')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categories</h2>
        <a href="{{ route('Seller.categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($categories->isEmpty())
        <p>No categories found.</p>
    @else
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <strong>{{ $category->name }}</strong>
                    @if($category->children->count())
                        <ul class="mt-2">
                            @foreach($category->children as $child)
                                <li>
                                    {{ $child->name }}
                                    <a href="{{ route('Seller.categories.edit', $child) }}" class="text-info ms-2">Edit</a>
                                    <form action="{{ route('Seller.categories.destroy', $child) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-link text-danger p-0">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="float-end">
                        <a href="{{ route('Seller.categories.show', $category) }}" class="btn btn-sm btn-secondary">View</a>
                        <a href="{{ route('Seller.categories.edit', $category) }}" class="btn btn-sm btn-info">Edit</a>
                        <form action="{{ route('Seller.categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
