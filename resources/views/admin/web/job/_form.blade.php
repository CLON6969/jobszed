@php
    $isEdit = isset($job);
@endphp

<div class="row g-3">
    {{-- Basic fields --}}
    <div class="col-md-6">
        <label class="form-label">Job Title</label>
        <input type="text" name="title" class="form-control" 
            value="{{ old('title', $job->title ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" class="form-control" 
            value="{{ old('slug', $job->slug ?? '') }}" required>
    </div>

    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control" required>{{ old('description', $job->description ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label">Employment Type</label>
        <input type="text" name="employment_type" class="form-control" 
            value="{{ old('employment_type', $job->employment_type ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Work Setup</label>
        <input type="text" name="work_setup" class="form-control" 
            value="{{ old('work_setup', $job->work_setup ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" 
            value="{{ old('location', $job->location ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control" 
            value="{{ old('country', $job->country ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control" 
            value="{{ old('department', $job->department ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Level</label>
        <input type="text" name="level" class="form-control" 
            value="{{ old('level', $job->level ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Salary Range</label>
        <input type="text" name="salary_range" class="form-control" 
            value="{{ old('salary_range', $job->salary_range ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Application Deadline</label>
        <input type="date" name="application_deadline" class="form-control" 
            value="{{ old('application_deadline', $isEdit && $job->application_deadline ? $job->application_deadline->format('Y-m-d') : '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Posted By (User ID)</label>
        <input type="number" name="posted_by" class="form-control" 
            value="{{ old('posted_by', $job->posted_by ?? auth()->id()) }}" required>
    </div>
</div>

{{-- Dynamic collections sections --}}
@include('admin.web.job.partials.skills', ['skills' => old('skills', $isEdit ? $job->skills->toArray() : [])])
@include('admin.web.job.partials.experiences', ['experiences' => old('experiences', $isEdit ? $job->experiences->toArray() : [])])
@include('admin.web.job.partials.qualifications', ['qualifications' => old('qualifications', $isEdit ? $job->qualifications->toArray() : [])])
@include('admin.web.job.partials.questions', ['questions' => old('questions', $isEdit ? $job->questions->toArray() : [])])
