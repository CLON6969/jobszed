@extends('layouts.seller')

@section('content')
<div class="container py-4">
    <h2>{{ $category->name }}</h2>

    @if($category->icon)
        <img src="{{ asset('storage/' . $category->icon) }}" width="100" class="mb-3">
    @endif

    <p>{{ $category->description ?? 'No description provided.' }}</p>

    @if($category->parent)
        <p><strong>Parent:</strong> {{ $category->parent->name }}</p>
    @endif

    @if($category->children->count())
        <h5>Subcategories</h5>
        <ul>
            @foreach($category->children as $child)
                <li>{{ $child->name }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('Seller.categories.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection
