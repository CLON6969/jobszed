@extends('layouts.admin_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Job Posts & Applications</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Deadline</th>
                <th>Applications</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
            <tr>
                <td>{{ $job->title }}</td>
                <td>{{ $job->application_deadline }}</td>
                <td>{{ $job->applications_count }}</td>
                <td><a href="{{ route('admin.web.applications.applicants', $job->id) }}" class="btn btn-sm btn-primary">View Applicants</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
