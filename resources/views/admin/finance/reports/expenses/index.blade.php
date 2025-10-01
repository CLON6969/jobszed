@extends('layouts.admin')

@section('title', 'Expenses Report')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">💸 Expenses Report</h2>
        <div class="space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Export CSV</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Export PDF</button>
        </div>
    </div>

    {{-- Filters --}}
    @include('admin.finance.reports.partials.filters', [
        'filters' => ['category', 'vendor', 'date_range']
    ])

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Expenses</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalExpenses }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Average Expense</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $averageExpense }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Recurring</p>
            <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $recurringCount }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">One-time</p>
            <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $oneTimeCount }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2">Expense ID</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Vendor</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Currency</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Expense Date</th>
                    <th class="px-4 py-2">Recurrence</th>
                    <th class="px-4 py-2">Project/Dept</th>
                    <th class="px-4 py-2">Invoice File</th>
                    <th class="px-4 py-2">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($expenses as $expense)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">{{ $expense->id }}</td>
                        <td class="px-4 py-2">{{ $expense->description }}</td>
                        <td class="px-4 py-2">{{ $expense->vendor }}</td>
                        <td class="px-4 py-2">{{ $expense->category }}</td>
                        <td class="px-4 py-2">{{ currency_format($expense->amount, $expense->currency) }}</td>
                        <td class="px-4 py-2">{{ $expense->currency }}</td>
                        <td class="px-4 py-2">
                            <span class="text-xs px-2 py-1 rounded-full text-white bg-{{ $expense->status === 'paid' ? 'green' : 'yellow' }}-500">
                                {{ ucfirst($expense->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ ucfirst($expense->recurrence) }}</td>
                        <td class="px-4 py-2">{{ $expense->department ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @if ($expense->invoice_file)
                                <a href="{{ asset('/public/storage/' . $expense->invoice_file) }}" class="text-blue-500 underline" target="_blank">View</a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $expense->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center px-4 py-6 text-gray-500">No expenses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $expenses->links() }}
    </div>
</div>
@endsection




