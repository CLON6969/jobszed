@extends('layouts.admin')

@section('content')
<div class="container">
    <h5 class="mb-5 text-center"> {{ $user->name }} <i class="fas fa-user-check text-blue-600"></i></h5>

   
    {{-- Job Applicant Details --}}
    <x-applicant.card class="mb-4">
        <x-slot name="title">
            <div class="fw-bold fs-5 pb-2 mb-3 text-center">Personal Details</div>
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
                    <th>Professional summary </th>
                    <td>{{ $profile->professional_summary }}</td>
                    <th>Address</th>
                    <td>{{ $profile->address}}</td>
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
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#certModal{{ $index }}">
            View
        </button>

        <!-- Modal -->
        <div class="modal fade" id="certModal{{ $index }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title w-100 text-center">{{ $cert->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        @php
                            $fileUrl = asset('public/storage/' . $cert->authority_certificate_path);
                            $ext = strtolower(pathinfo($cert->authority_certificate_path, PATHINFO_EXTENSION));
                        @endphp

                        {{-- Images --}}
                        @if(in_array($ext, ['jpg','jpeg','png','gif']))
                            <img src="{{ $fileUrl }}" class="img-fluid rounded shadow" alt="Certificate">

                        {{-- PDFs --}}
                        @elseif($ext === 'pdf')
                            <iframe src="{{ $fileUrl }}" width="100%" height="600px" frameborder="0"></iframe>

                        {{-- Videos --}}
                        @elseif(in_array($ext, ['mp4','webm','ogg']))
                            <video controls width="100%" class="rounded shadow">
                                <source src="{{ $fileUrl }}" type="video/{{ $ext }}">
                                Your browser does not support the video tag.
                            </video>

                        {{-- Word, Excel, PowerPoint --}}
                        @elseif(in_array($ext, ['doc','docx','xls','xlsx','ppt','pptx']))
                            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" 
                                    width="100%" height="600px" frameborder="0"></iframe>

                        {{-- Fallback: Download --}}
                        @else
                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-info">
                                Download File
                            </a>
                        @endif
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

 

</div>
@endsection
