@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    @include('admin.job_user_summary.partials.layout', [
        'title' => 'Job & User Summary',
        'summary' => [
            ['label' => 'Open Jobs', 'value' => $openJobs, 'class' => 'bg-payments'],
            ['label' => 'Closed Jobs', 'value' => $closedJobs, 'class' => 'bg-expenses'],
            ['label' => 'Total Applications', 'value' => $totalApplications, 'class' => 'bg-budgets'],
            ['label' => 'Applications Today', 'value' => $applicationsToday, 'class' => 'bg-invoices'],
            ['label' => 'Applicants', 'value' => $applicants, 'class' => 'bg-payments'],
            ['label' => 'Staff', 'value' => $staff, 'class' => 'bg-expenses'],
            ['label' => 'Total Users', 'value' => $totalUsers, 'class' => 'bg-budgets'],
        ],
        'jobTrendData' => [
            'labels' => $jobTrendLabels,
            'data' => $jobTrendCounts
        ],
        'latestJobs' => $latestJobs,
        'users' => $users
    ])
</div>
@endsection
