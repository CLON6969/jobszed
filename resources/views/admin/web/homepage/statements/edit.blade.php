@extends('layouts.admin_dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Company Statement</div>
        <div class="card-body">
            <form action="{{ route('admin.web.homepage.statements.update', $statement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf 

                <div class="form-group mb-3">
                    <label>Title</label>
                    <input type="text" name="title1" class="form-control" value="{{ old('title1', $statement->title1) }}" required>
                    @error('title1') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Main Content</label>
                    <textarea name="title1_main_content" rows="4" class="form-control">{{ old('title1_main_content', $statement->title1_main_content) }}</textarea>
                    @error('title1_main_content') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Sub Content</label>
                    <textarea name="title1_sub_content" rows="3" class="form-control">{{ old('title1_sub_content', $statement->title1_sub_content) }}</textarea>
                    @error('title1_sub_content') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Background Picture</label><br>
                    @if($statement->background_picture)
                        <img src="{{ asset('/public/storage/uploads/pics/' . $statement->background_picture) }}" width="120" class="mb-2 rounded border">
                    @endif
                    <input type="file" name="background_picture" class="form-control">
                    @error('background_picture') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <button class="btn btn-success">Update</button>
                <a href="{{ route('admin.web.homepage.statements.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
