@extends('layouts.admin')

@section('content')
<div class="container py-5">
{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <h2 class="mb-5 text-center">Application Review for {{ $user->name }}</h2>

    {{-- Application Status --}}
    <form method="POST" action="{{ route('user.employer.web.applications.update', $application->id) }}" class="mb-5">
        @csrf
        @method('PUT')
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <span class="text-center w-100">Application Status</span>
                <button type="submit" class="btn btn-light btn-sm rounded-pill">Update</button>
            </div>
            <div class="card-body">
                <select name="status" class="form-select" required>
                    @foreach(['submitted', 'shortlisted', 'interview', 'accepted', 'rejected'] as $status)
                        <option value="{{ $status }}" {{ $application->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    {{-- Job Applicant Details --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Job Applicant Details</div>
        </x-slot>
        <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <tr>
                    <th width="25%">Name</th>
                    <td>{{ $user->name }}</td>
                    <th width="25%">Gender</th>
                    <td>{{ ucfirst($profile->gender) }}</td>
                </tr>
                <tr>
                    <th>Date Of Birth</th>
                    <td>{{ $profile->date_of_birth }}</td>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <th>National ID</th>
                    <td>{{ $profile->national_id }}</td>
                </tr>
                <tr>
                    <th>Professional Field</th>
                    <td>{{ $profile->professional_field }}</td>
                    <th>Highest Qualification</th>
                    <td>{{ $profile->highest_qualification }}</td>
                </tr>
            </table>
        </div>
    </x-applicant.card>

    {{-- Certifications --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Certifications</div>
        </x-slot>
        @forelse($certifications as $index => $cert)
            <div class="table-responsive mb-3">
                <table class="table table-sm table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Organization</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Obtained</th>
                            <th>Certificate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $cert->name }}</td>
                            <td>{{ $cert->certification_type }}</td>
                            <td>{{ $cert->issuing_organization }}</td>
                            <td>{{ $cert->level }}</td>
                            <td>{{ $cert->status }}</td>
                            <td>{{ $cert->obtained_date }}</td>
                            <td>
                                @if($cert->authority_certificate_path)
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#certModal{{ $index }}">View</button>
                                    <div class="modal fade" id="certModal{{ $index }}" tabindex="-1">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content rounded-4 shadow">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title text-center w-100">{{ $cert->name }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <iframe src="{{ asset('public/storage/' . $cert->authority_certificate_path) }}" width="100%" height="600px" frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @empty
            <p class="text-center">No certifications provided.</p>
        @endforelse
    </x-applicant.card>

    {{-- Education Qualifications --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Education Qualifications</div>
        </x-slot>
        <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Educational Institution</th>
                        <th>Level</th>
                        <th>Qualification</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($educations as $index => $edu)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $edu->institution_name }}</td>
                            <td>{{ $edu->level }}</td>
                            <td>{{ $edu->field_of_study }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">No education history provided.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-applicant.card>

    {{-- Employment History --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Employment History</div>
        </x-slot>
        <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($experiences as $index => $exp)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $exp->employer }}</td>
                            <td>{{ $exp->job_title }}</td>
                            <td>{{ $exp->start_date }}</td>
                            <td>{{ $exp->end_date ?? 'Present' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">No employment history provided.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-applicant.card>

    {{-- Voluntary Disclosures --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Voluntary Disclosures</div>
        </x-slot>
        <div class="table-responsive">
            @if($disclosure)
                <table class="table table-sm table-bordered mb-0">
                    <tbody>
                        <tr><th>Disability</th><td>{{ $disclosure->disability_status }}</td></tr>
                        <tr><th>Ethnicity</th><td>{{ $disclosure->ethnicity }}</td></tr>
                        <tr><th>Gender Identity</th><td>{{ $disclosure->gender_identity }}</td></tr>
                        <tr><th>Veteran</th><td>{{ $disclosure->is_veteran ? 'Yes' : 'No' }}</td></tr>
                    </tbody>
                </table>
            @else
                <p class="text-center">No disclosure info provided.</p>
            @endif
        </div>
    </x-applicant.card>

    {{-- Application Materials --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Application Materials</div>
        </x-slot>
        <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0">
                <tbody>
                    <tr>
                        <th>Cover Letter</th>
                        <td>
                            @if($application->cover_letter)
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#coverLetterModal">
                                    View Cover Letter
                                </button>

                                <!-- Cover Letter Modal -->
                                <div class="modal fade" id="coverLetterModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content rounded-4 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title text-center w-100">Cover Letter</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-3" style="max-height: 70vh; overflow-y: auto; text-align: left;">
                                                    {!! nl2br(e($application->cover_letter)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>CV</th>
                        <td>
                            @if($application->cv)
                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cvModal">
                                    View CV
                                </button>

                                <!-- CV Modal -->
                                <div class="modal fade" id="cvModal" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content rounded-4 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title text-center w-100">Curriculum Vitae (CV)</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <iframe src="{{ asset('public/storage/' . $application->cv) }}" width="100%" height="600px" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-applicant.card>

</div>
@endsection
