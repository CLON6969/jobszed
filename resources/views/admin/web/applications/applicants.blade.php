@extends('layouts.admin_dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Applicants for: {{ $job->title }}</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Email</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applications as $application)
            <tr>
                <td>{{ $application->user->name }}</td>
                <td>{{ $application->user->email }}</td>
                <td>{{ ucfirst($application->status ?? 'pending') }}</td>
                <td>{{ $application->submitted_at?->format('Y-m-d') ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.web.applications.show', $application->id) }}" class="btn btn-sm btn-info">Review</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
