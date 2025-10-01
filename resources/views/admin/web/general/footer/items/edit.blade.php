@extends('layouts.admin')
@section('content')
<div class="container">
    <h2>Edit Footer Item</h2>
    <form action="{{ route('admin.web.general.footer.items.update', $item) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Text</label>
            <input type="text" name="text" class="form-control" value="{{ $item->text }}" required>
        </div>
        <div class="mb-3">
            <label>URL</label>
            <input type="text" name="url" class="form-control" value="{{ $item->url }}" required>
        </div>
        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1" {{ $item->is_active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$item->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Footer Title</label>
            <select name="footer_title_id" class="form-control" required>
                @foreach($titles as $title)
                    <option value="{{ $title->id }}" {{ $item->footer_title_id == $title->id ? 'selected' : '' }}>{{ $title->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
