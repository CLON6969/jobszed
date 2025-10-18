@extends('layouts.seller')

@section('content')
<div class="container py-4">
    <h2>Add Category</h2>

    <form method="POST" action="{{ route('Seller.categories.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Parent Category (optional)</label>
            <select name="parent_id" class="form-select">
                <option value="">None</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Icon</label>
            <input type="file" name="icon" class="form-control">
        </div>

        <button class="btn btn-success">Save Category</button>
    </form>
</div>
@endsection
