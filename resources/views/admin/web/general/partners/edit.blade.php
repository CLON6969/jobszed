@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Partner</h2>

    <form action="{{ route('admin.web.general.partners.update', $partner->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Icon (Font Awesome class)</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon', $partner->icon) }}">
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $partner->name) }}" required>
        </div>

        <div class="mb-3">
            <label>URL</label>
            <input type="text" name="name_url" class="form-control" value="{{ old('name_url', $partner->name_url) }}" required>
        </div>

        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $partner->sort_order) }}" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $partner->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
