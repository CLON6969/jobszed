@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Create Footer Title</h2>

    <form action="{{ route('admin.web.general.footer.titles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
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