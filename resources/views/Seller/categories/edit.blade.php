@extends('layouts.Seller')

@section('content')
<div class="container py-4">
    <h2>Edit Category</h2>

    <form method="POST" action="{{ route('Seller.categories.update', $category) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Parent Category</label>
            <select name="parent_id" class="form-select">
                <option value="">None</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" @selected($category->parent_id == $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Icon</label><br>
            @if($category->icon)
                <img src="{{ asset('storage/' . $category->icon) }}" width="80" class="mb-2">
            @endif
            <input type="file" name="icon" class="form-control">
        </div>

        <button class="btn btn-primary">Update Category</button>
    </form>
</div>
@endsection
