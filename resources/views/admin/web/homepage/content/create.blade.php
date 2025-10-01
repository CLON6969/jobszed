
@extends('layouts.web')

@section('content')
<div class="container">
    <h2>Add Homepage Link</h2>

    {{-- Include session alerts --}}
    @include('partials.alerts')

    <form action="{{ route('admin.web.homepage.table.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>URL Name</label>
            <input type="text" name="url_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>URL</label>
            <input type="url" name="url" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Picture</label>
            <input type="file" name="picture" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
</div>
@endsection
