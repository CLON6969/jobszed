@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="buttons">
        <h4>Add New Record</h4>
        <a href="{{ route('admin.web.homepage.table.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('admin.web.homepage.table.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label>Title</label>
            <input type="text" name="title1" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Content</label>
            <textarea name="title1_content" class="form-control" required></textarea>
        </div>

        <div class="mb-2">
            <label>Small Text</label>
            <input type="text" name="title1_small_text" class="form-control">
        </div>

        <div class="mb-2">
            <label>Picture</label>
            <input type="file" name="picture" class="form-control" required>
        </div>

        <button class="btn btn-success mt-2">Save</button>
    </form>
</div>
@endsection
