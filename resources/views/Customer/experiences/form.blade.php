@php $isEdit = isset($experience); @endphp
@extends('layouts.base')
@section('content')
<div class="container">
    <h4>{{ $isEdit ? 'Edit' : 'Add' }} Experience</h4>
    <form method="POST" action="{{ $isEdit ? route('user.applicant.experiences.update', $experience) : route('user.applicant.experiences.store') }}">
        @csrf @if($isEdit) @method('PUT') @endif
        <div class="row">
            <div class="col-md-4">
                <label>Employer</label>
                <input type="text" name="employer" required class="form-control" value="{{ old('employer', $experience->employer ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>Job Title</label>
                <input type="text" name="job_title" required class="form-control" value="{{ old('job_title', $experience->job_title ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>Start Date</label>
                <input type="date" name="start_date" required class="form-control" value="{{ old('start_date', $experience->start_date ?? '') }}">
            </div>
            <div class="col-md-4">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $experience->end_date ?? '') }}">
            </div>
        </div>
        <div class="mt-3">
            <button class="btn btn-success">{{ $isEdit ? 'Update' : 'Submit' }}</button>
            <a href="{{ route('user.applicant.experiences.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
