@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit About Entry</h2>

    <form action="{{ route('admin.web.about.table.update', $table->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Current Picture</label><br>
            @if($table->picture)
                <img src="{{ asset('/public/storage/uploads/pics/' . $table->picture) }}" alt="pic" width="100" class="mb-2">
            @endif
            <input type="file" name="picture" class="form-control">
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title1" class="form-control" value="{{ old('title1', $table->title1) }}" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="title1_content" class="form-control">{{ old('title1_content', $table->title1_content) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Small Text</label>
            <input type="text" name="title1_small_text" class="form-control" value="{{ old('title1_small_text', $table->title1_small_text) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.web.about.table.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
