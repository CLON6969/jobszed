@extends('layouts.admin_dashboard')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Opportunity</div>
        <div class="card-body">
            <form action="{{ route('admin.web.opportunities.update', $opportunity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="form-group mb-3">
                    <label>Title</label>
                    <input name="title" class="form-control" value="{{ old('title', $opportunity->title) }}" required>
                    @error('title')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Summary</label>
                    <textarea name="summary" class="form-control">{{ old('summary', $opportunity->summary) }}</textarea>
                    @error('summary')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Overlay Intro</label>
                    <input name="overlay_intro" class="form-control" value="{{ old('overlay_intro', $opportunity->overlay_intro) }}">
                    @error('overlay_intro')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Overlay Details</label>
                    <textarea name="overlay_details" class="form-control">{{ old('overlay_details', $opportunity->overlay_details) }}</textarea>
                    @error('overlay_details')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label>Current Image</label><br>
                    @if($opportunity->image)
                        <img src="{{ asset('/public/storage/opportunities/' . $opportunity->image) }}" width="120" class="mb-2">
                    @endif
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
