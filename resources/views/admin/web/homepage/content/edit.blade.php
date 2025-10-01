@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Edit Homepage Content</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.web.homepage.content.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title 1 -->
        <div class="mb-3">
            <label>Title 1</label>
            <input type="text" name="title1" class="form-control" value="{{ old('title1', $content->title1) }}" required>
        </div>

        <div class="mb-3">
            <label>Title 1 Content</label>
            <textarea name="title1_content" class="form-control">{{ old('title1_content', $content->title1_content) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Title 1 Sub Content</label>
            <textarea name="title1_sub_content" class="form-control">{{ old('title1_sub_content', $content->title1_sub_content) }}</textarea>
        </div>

        <!-- Title 2 -->
        <div class="mb-3">
            <label>Title 2</label>
            <input type="text" name="title2" class="form-control" value="{{ old('title2', $content->title2) }}" required>
        </div>

        <div class="mb-3">
            <label>Title 2 Content</label>
            <textarea name="title2_content" class="form-control">{{ old('title2_content', $content->title2_content) }}</textarea>
        </div>

        <!-- Background Picture -->
        <div class="mb-3">
            <label>Background Picture</label>
            <input type="file" name="background_picture" class="form-control">
            @if($content->background_picture)
                <img src="{{ asset('/public/storage/uploads/pics/' . $content->background_picture) }}" width="200" class="mt-2">
            @endif
        </div>



        <!-- Button 1 -->
        <div class="mb-3">
            <label>Button 1 Name</label>
            <input type="text" name="button1_name" class="form-control" value="{{ old('button1_name', $content->button1_name) }}">
        </div>

        <div class="mb-3">
            <label>Button 1 URL</label>
            <input type="text" name="button1_url" class="form-control" value="{{ old('button1_url', $content->button1_url) }}">
        </div>

        <!-- Background Picture 2 -->
        <div class="mb-3">
            <label>Background Picture 2</label>
            <input type="file" name="background_picture2" class="form-control">
            @if($content->background_picture2)
                <img src="{{ asset('/public/storage/uploads/pics/' . $content->background_picture2) }}" width="200" class="mt-2">
            @endif
        </div>

        <!-- Title 3 -->
        <div class="mb-3">
            <label>Title 3</label>
            <input type="text" name="title3" class="form-control" value="{{ old('title3', $content->title3) }}">
        </div>

        <div class="mb-3">
            <label>Title 3 Content</label>
            <textarea name="title3_content" class="form-control">{{ old('title3_content', $content->title3_content) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Title 3 Sub Content</label>
            <textarea name="title3_sub_content" class="form-control">{{ old('title3_sub_content', $content->title3_sub_content) }}</textarea>
        </div>

        <!-- Button 2 -->
        <div class="mb-3">
            <label>Button 2 Name</label>
            <input type="text" name="button2_name" class="form-control" value="{{ old('button2_name', $content->button2_name) }}">
        </div>

        <div class="mb-3">
            <label>Button 2 URL</label>
            <input type="text" name="button2_url" class="form-control" value="{{ old('button2_url', $content->button2_url) }}">
        </div>

        <!-- Title 4 -->
        <div class="mb-3">
            <label>Title 4</label>
            <input type="text" name="title4" class="form-control" value="{{ old('title4', $content->title4) }}">
        </div>

        <div class="mb-3">
            <label>Title 4 Content</label>
            <textarea name="title4_content" class="form-control">{{ old('title4_content', $content->title4_content) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Title 4 Sub Content</label>
            <textarea name="title4_sub_content" class="form-control">{{ old('title4_sub_content', $content->title4_sub_content) }}</textarea>
        </div>

        <!-- Button 3 -->
        <div class="mb-3">
            <label>Button 3 Name</label>
            <input type="text" name="button3_name" class="form-control" value="{{ old('button3_name', $content->button3_name) }}">
        </div>

        <div class="mb-3">
            <label>Button 3 URL</label>
            <input type="text" name="button3_url" class="form-control" value="{{ old('button3_url', $content->button3_url) }}">
        </div>

        <!-- Button 4 -->
        <div class="mb-3">
            <label>Button 4 Name</label>
            <input type="text" name="button4_name" class="form-control" value="{{ old('button4_name', $content->button4_name) }}">
        </div>

        <div class="mb-3">
            <label>Button 4 URL</label>
            <input type="text" name="button4_url" class="form-control" value="{{ old('button4_url', $content->button4_url) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Homepage</button>
    </form>
</div>
@endsection