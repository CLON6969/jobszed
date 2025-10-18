@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Edit Education</h2>

    <form action="{{ route('user.applicant.educations.update', $education) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Level</label>
            <input type="text" name="level" class="form-control" value="{{ old('level', $education->level) }}" required>
            @error('level') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Field of Study</label>
            <input type="text" name="field_of_study" class="form-control" value="{{ old('field_of_study', $education->field_of_study) }}" required>
            @error('field_of_study') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('user.applicant.educations.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
