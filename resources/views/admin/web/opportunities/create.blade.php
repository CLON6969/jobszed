@extends('layouts.admin_dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Create Opportunity</div>
        <div class="card-body">
            <form action="{{ route('admin.web.opportunities.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label>Title</label>
                    <input name="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Summary</label>
                    <textarea name="summary" class="form-control">{{ old('summary') }}</textarea>
                    @error('summary')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Overlay Intro</label>
                    <input name="overlay_intro" class="form-control" value="{{ old('overlay_intro') }}">
                    @error('overlay_intro')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Overlay Details</label>
                    <textarea name="overlay_details" class="form-control">{{ old('overlay_details') }}</textarea>
                    @error('overlay_details')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" required>
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
