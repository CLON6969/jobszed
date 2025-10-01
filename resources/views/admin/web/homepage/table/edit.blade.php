@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="buttons">
        <h4>Edit Record</h4>
        <a href="{{ route('admin.web.homepage.table.index') }}" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <form action="{{ route('admin.web.homepage.table.update', $table->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-2">
            <label>Title</label>
            <input type="text" name="title1" class="form-control" value="{{ old('title1', $table->title1) }}" required>
        </div>

        <div class="mb-2">
            <label>Content</label>
            <textarea name="title1_content" class="form-control" required>{{ old('title1_content', $table->title1_content) }}</textarea>
        </div>

        <div class="mb-2">
            <label>Small Text</label>
            <input type="text" name="title1_small_text" class="form-control" value="{{ old('title1_small_text', $table->title1_small_text) }}">
        </div>

        <div class="mb-2">
            <label>Picture</label>
            <input type="file" name="picture" class="form-control">
            @if($table->picture)
                <img src="{{ asset('/public/storage/uploads/pics/' . $table->picture) }}" width="120" class="mt-2" style="border-radius: 0.5rem;">
            @endif
        </div>

        <button class="btn btn-primary mt-2">Update</button>
    </form>
</div>
@endsection
