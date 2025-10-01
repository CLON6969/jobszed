@extends('layouts.admin_dashboard2')

@section('content')
<div class="container-fluid py-4">

    @if (session('status'))
    @php
        $messages = [
            'shortlisted-saved' => '✅ Shortlisted details saved successfully!',
            'rejected-saved' => '✅ Rejected details saved successfully!',
            'interview-saved' => '✅ Interview details saved successfully!',
            'accepted-saved' => '✅ Accepted details saved successfully!',
            'shortlisted-deleted' => '🗑 Shortlisted details deleted successfully!',
            'rejected-deleted' => '🗑 Rejected details deleted successfully!',
            'interview-deleted' => '🗑 Interview details deleted successfully!',
            'accepted-deleted' => '🗑 Accepted details deleted successfully!',
            'email-template-updated' => '✉️ Email template updated successfully!',
        ];
    @endphp

    <div id="statusAlert" 
         class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center justify-content-between px-4 py-3 mt-3 mx-3 rounded-4"
         role="alert"
         style="background: linear-gradient(135deg, #28a745, #218838); color: #fff; font-weight: 500; animation: slideDown 0.4s ease;">
         
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-2 fa-lg"></i>
            <span>{{ $messages[session('status')] ?? '✅ Action completed successfully!' }}</span>
        </div>

        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <style>
        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
@endif


    <h2 class="mb-4">Application Management</h2>

    {{-- Top Half --}}
    <div class="row">
        {{-- Left: Select Job --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Select Job</h5>
                </div>
                <div class="card-body">
                    <select id="jobSelect" class="form-select">
                        <option value="">-- Choose a Job --</option>
                        @foreach($jobPosts as $job)
                            <option value="{{ $job->id }}">
                                {{ $job->title }} ({{ $job->applications->count() }} applicants)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Right: Dynamic job response details --}}
        <div class="col-md-8">
            @foreach($jobPosts as $job)
            <div class="job-details d-none" id="job-{{ $job->id }}">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">General Responses for: {{ $job->title }}</h5>
                    </div>
                    <div class="card-body">

                        {{-- Shortlisted --}}
                        <form method="POST" action="{{ route('admin.web.Email_application_management.storeDetail', [$job->id, 'shortlisted']) }}">
                            @csrf
                            <h6>Shortlisted</h6>
                            <textarea name="notes" class="form-control mb-2">{{ $job->shortlistedDetail->notes ?? '' }}</textarea>
                            <button class="btn btn-primary btn-sm">Save</button>
                        </form>

                        <hr>

                        {{-- Rejected --}}
                        <form method="POST" action="{{ route('admin.web.Email_application_management.storeDetail', [$job->id, 'rejected']) }}">
                            @csrf
                            <h6>Rejected</h6>
                            <input type="text" name="reason" class="form-control mb-2"
                                value="{{ $job->rejectedDetail->reason ?? '' }}">
                            <button class="btn btn-primary btn-sm">Save</button>
                        </form>

                        <hr>

                        {{-- Interview --}}
                        <form method="POST" action="{{ route('admin.web.Email_application_management.storeDetail', [$job->id, 'interview']) }}">
                            @csrf
                            <h6>Interview</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="type" class="form-control"
                                        placeholder="Type"
                                        value="{{ $job->interviewDetail->type ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="date" class="form-control"
                                        value="{{ $job->interviewDetail->date ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="time" name="time" class="form-control"
                                        value="{{ $job->interviewDetail->time ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="venue" class="form-control"
                                        placeholder="Venue"
                                        value="{{ $job->interviewDetail->venue ?? '' }}">
                                </div>
                            </div>
                            <textarea name="requirements" class="form-control mt-2"
                                placeholder="Requirements">{{ $job->interviewDetail->requirements ?? '' }}</textarea>
                            <button class="btn btn-primary btn-sm mt-2">Save</button>
                        </form>

                        <hr>

                        {{-- Accepted --}}
                        <form method="POST" action="{{ route('admin.web.Email_application_management.storeDetail', [$job->id, 'accepted']) }}">
                            @csrf
                            <h6>Accepted</h6>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ $job->acceptedDetail->start_date ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="position" class="form-control"
                                        placeholder="Position"
                                        value="{{ $job->acceptedDetail->position ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="salary" class="form-control"
                                        placeholder="Salary"
                                        value="{{ $job->acceptedDetail->salary ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="other_terms" class="form-control"
                                        placeholder="Other Terms"
                                        value="{{ $job->acceptedDetail->other_terms ?? '' }}">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm mt-2">Save</button>
                        </form>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom Half --}}
    <div class="row mt-4">
        {{-- Left: Select Email Template --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Select Template</h5>
                </div>
                <div class="card-body">
                    <select id="templateSelect" class="form-select">
                        <option value="">-- Choose Template --</option>
                        @foreach($emailTemplates as $template)
                            <option value="{{ $template->id }}">{{ $template->type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Right: Email Template Form --}}
        <div class="col-md-8">
            @foreach($emailTemplates as $template)
            <div class="template-details d-none" id="template-{{ $template->id }}">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Template: {{ $template->name }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.web.Email_application_management.updateEmailTemplate', $template->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-2">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control"
                                    value="{{ $template->subject }}">
                            </div>
                            <div class="mb-2">
                                <label>Body</label>
                                <textarea name="body" class="form-control" rows="5">{{ $template->body }}</textarea>
                            </div>
                            <button class="btn btn-primary btn-sm">Update Template</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

{{-- Simple script for toggling --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jobSelect = document.getElementById('jobSelect');
    const templateSelect = document.getElementById('templateSelect');

    jobSelect.addEventListener('change', function () {
        document.querySelectorAll('.job-details').forEach(div => div.classList.add('d-none'));
        if (this.value) {
            document.getElementById('job-' + this.value).classList.remove('d-none');
        }
    });

    templateSelect.addEventListener('change', function () {
        document.querySelectorAll('.template-details').forEach(div => div.classList.add('d-none'));
        if (this.value) {
            document.getElementById('template-' + this.value).classList.remove('d-none');
        }
    });
});
</script>
@endsection
