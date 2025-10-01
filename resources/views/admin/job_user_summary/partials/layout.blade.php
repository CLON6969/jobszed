@extends('layouts.app')


@section('title', 'Dashboard Summary')

@section('content')
<div>
    <div class="container mx-auto px-4 py-6">

        {{-- Dark Mode Toggle --}}
        <div class="flex justify-end mb-4">
            <button
                @click="dark = !dark"
                class="px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none"
            >
                <span x-show="!dark">🌞 Light Mode</span>
                <span x-show="dark">🌙 Dark Mode</span>
            </button>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="shadow p-4 rounded text-center bg-green-100 dark:bg-green-800 transition-colors">
                <p class="text-green-800 dark:text-green-200 text-sm">Total Users</p>
                <p class="text-2xl font-bold text-green-900 dark:text-green-100">{{ $totalUsers }}</p>
            </div>
            <div class="shadow p-4 rounded text-center bg-blue-100 dark:bg-blue-800 transition-colors">
                <p class="text-blue-800 dark:text-blue-200 text-sm">Total Applications</p>
                <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ $totalApplications }}</p>
            </div>
            <div class="shadow p-4 rounded text-center bg-yellow-100 dark:bg-yellow-800 transition-colors">
                <p class="text-yellow-800 dark:text-yellow-200 text-sm">Open Job Posts</p>
                <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ $openJobs }}</p>
            </div>
            <div class="shadow p-4 rounded text-center bg-purple-100 dark:bg-purple-800 transition-colors">
                <p class="text-purple-800 dark:text-purple-200 text-sm">Shortlisted Applicants</p>
                <p class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $totalShortlisted ?? 0 }}</p>
            </div>
        </div>

        {{-- Job Trends Chart --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8 transition-colors">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4"> Job Trends (Last 6 Months)</h3>
            <canvas id="jobTrendsChart" height="100"></canvas>
        </div>

        {{-- Latest Job Posts --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8 transition-colors">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4"> Latest Job Posts</h3>
            <table class="min-w-full text-sm text-gray-900 dark:text-gray-100">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Deadline</th>
                        <th class="px-4 py-2">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestJobs as $job)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-2">{{ $job->title }}</td>
                            <td class="px-4 py-2">{{ optional($job->application_deadline)->format('Y-m-d') ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ $job->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">No job posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Users Table --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 transition-colors">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4"> Users</h3>
            <input
                type="text"
                placeholder="Search users..."
                id="userSearch"
                class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full mb-4 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            >
            <table class="min-w-full text-sm text-gray-900 dark:text-gray-100" id="userTable">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-left">
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-t border-gray-200 dark:border-gray-700 user-row">
                            <td class="px-4 py-2 name">{{ $user->name }}</td>
                            <td class="px-4 py-2 email">{{ $user->email }}</td>
                            <td class="px-4 py-2 role">{{ $user->role->name ?? 'User' }}</td>
                            <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('jobTrendsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($jobTrendLabels) !!},
            datasets: [{
                label: 'Jobs Posted',
                backgroundColor: '#3B82F6',
                data: {!! json_encode($jobTrendCounts) !!}
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    document.getElementById('userSearch').addEventListener('input', function () {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.user-row').forEach(row => {
            const name = row.querySelector('.name').textContent.toLowerCase();
            const email = row.querySelector('.email').textContent.toLowerCase();
            const role = row.querySelector('.role').textContent.toLowerCase();
            row.style.display = (name.includes(search) || email.includes(search) || role.includes(search)) ? '' : 'none';
        });
    });
</script>

