@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Social Link</h2>

    <form action="{{ route('admin.web.general.socials.update', $social->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Icon</label>
            <input type="text" name="icon" class="form-control" value="{{ old('icon', $social->icon) }}" required>
        </div>

        <div class="mb-3">
            <label>URL</label>
            <input type="text" name="name_url" class="form-control" value="{{ old('name_url', $social->name_url) }}" required>
        </div>

        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $social->sort_order) }}" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ $social->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection