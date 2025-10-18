@extends('layouts.base')

@section('content')
<div class="p-6 space-y-6">

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-gray-500 font-semibold">Total Jobs</h3>
            <p class="text-3xl font-bold">{{ $jobs->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-gray-500 font-semibold">Active Jobs</h3>
            <p class="text-3xl font-bold">{{ $activeJobs->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-gray-500 font-semibold">Closed Jobs</h3>
            <p class="text-3xl font-bold">{{ $closedJobs->count() }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-gray-500 font-semibold">Total Applications</h3>
            <p class="text-3xl font-bold">{{ $applications->count() }}</p>
        </div>
    </div>

    <!-- Calendar (Jobs Deadlines) -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-gray-700 font-bold mb-4">Job Deadlines Calendar</h3>
        <div id="calendar" class="w-full h-96 border rounded-lg"></div>
    </div>

    <!-- Job-level Applications -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-gray-700 font-bold mb-4">Applications Per Job</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full border divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Job</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Total Applications</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status Breakdown</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($applicationsPerJob as $jobTitle => $data)
                        <tr>
                            <td class="px-6 py-4 text-gray-800">{{ $jobTitle }}</td>
                            <td class="px-6 py-4 font-bold">{{ $data['total'] }}</td>
                            <td class="px-6 py-4">
                                @foreach($data['status'] as $status => $count)
                                    <span class="inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded mr-2 text-xs">{{ $status }}: {{ $count }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Applications Status Pie Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-gray-700 font-bold mb-4">Applications Status</h3>
        <canvas id="statusChart" class="w-full h-64"></canvas>
    </div>

    <!-- Jobs By Type Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-gray-700 font-bold mb-4">Jobs by Type</h3>
        <canvas id="jobTypeChart" class="w-full h-64"></canvas>
    </div>

    <!-- Jobs Posted Over Time -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-gray-700 font-bold mb-4">Jobs Posted Over Time</h3>
        <canvas id="jobsTrendChart" class="w-full h-64"></canvas>
    </div>

</div>

<!-- Scripts -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            @foreach($jobs as $job)
            {
                title: '{{ addslashes($job->title) }}',
                start: '{{ $job->application_deadline }}',
                url: '#',
                color: '{{ $job->application_deadline < now() ? "#EF4444" : "#10B981" }}'
            },
            @endforeach
        ]
    });
    calendar.render();

    // Charts
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: @json($statusCounts->keys()),
            datasets: [{
                data: @json($statusCounts->values()),
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
            }]
        }
    });

    const jobTypeChart = new Chart(document.getElementById('jobTypeChart'), {
        type: 'bar',
        data: {
            labels: @json($jobTypes->keys()),
            datasets: [{
                label: 'Jobs Count',
                data: @json($jobTypes->values()),
                backgroundColor: '#6366F1'
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    const jobsTrendChart = new Chart(document.getElementById('jobsTrendChart'), {
        type: 'line',
        data: {
            labels: @json($jobsPerMonth->keys()),
            datasets: [{
                label: 'Jobs Posted',
                data: @json($jobsPerMonth->values()),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
});
</script>
@endsection
