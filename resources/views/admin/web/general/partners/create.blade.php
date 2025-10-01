@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add New Partner</h2>

    <form action="{{ route('admin.web.general.partners.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Icon (Font Awesome class)</label>
            <input type="text" name="icon" class="form-control">
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>URL</label>
            <input type="text" name="name_url" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection