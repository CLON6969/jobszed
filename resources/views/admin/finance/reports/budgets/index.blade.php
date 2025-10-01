@extends('layouts.admin')

@section('title', 'Budgets Report')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">📊 Budgets Report</h2>
        <div class="space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Export CSV</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Export PDF</button>
        </div>
    </div>

    {{-- Filters --}}
    @include('admin.finance.reports.partials.filters', [
        'filters' => ['department', 'period']
    ])

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Budget</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalBudget }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Actual Expenses</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $totalExpenses }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Average Variance</p>
            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $averageVariance }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Status</p>
            <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $statusSummary }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2">Budget ID</th>
                    <th class="px-4 py-2">Department/Project</th>
                    <th class="px-4 py-2">Budget Period</th>
                    <th class="px-4 py-2">Budgeted Amount</th>
                    <th class="px-4 py-2">Actual Expenses</th>
                    <th class="px-4 py-2">Variance</th>
                    <th class="px-4 py-2">Currency</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($budgets as $budget)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">{{ $budget->id }}</td>
                        <td class="px-4 py-2">{{ $budget->department }}</td>
                        <td class="px-4 py-2">{{ ucfirst($budget->period) }}</td>
                        <td class="px-4 py-2">{{ currency_format($budget->budgeted_amount, $budget->currency) }}</td>
                        <td class="px-4 py-2">{{ currency_format($budget->actual_expenses, $budget->currency) }}</td>
                        <td class="px-4 py-2">
                            {{ currency_format($budget->budgeted_amount - $budget->actual_expenses, $budget->currency) }}
                        </td>
                        <td class="px-4 py-2">{{ $budget->currency }}</td>
                        <td class="px-4 py-2">
                            <span class="text-xs px-2 py-1 rounded-full text-white
                                @if($budget->status == 'Under Budget') bg-green-500
                                @elseif($budget->status == 'Over Budget') bg-red-500
                                @else bg-yellow-500 @endif">
                                {{ $budget->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $budget->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center px-4 py-6 text-gray-500">No budget records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $budgets->links() }}
    </div>
</div>
@endsection


