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
    @include('admin.finance.reports.partials.filters', ['filters' => ['category', 'vendor', 'date_range']])

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <x-admin.summary-box label="Total Expenses" value="{{ $totalExpenses }}" />
        <x-admin.summary-box label="Average Expense" value="{{ $averageExpense }}" />
        <x-admin.summary-box label="Recurring" value="{{ $recurringCount }}" class="text-blue-600 dark:text-blue-400" />
        <x-admin.summary-box label="One-time" value="{{ $oneTimeCount }}" class="text-green-600 dark:text-green-400" />
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
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Recurring?</th>
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
                        <td class="px-4 py-2">{{ $expense->vendor->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $expense->amount }}</td>
                        <td class="px-4 py-2">{{ $expense->currency }}</td>
                        <td class="px-4 py-2">{{ ucfirst($expense->status) }}</td>
                        <td class="px-4 py-2">{{ $expense->expense_date }}</td>
                        <td class="px-4 py-2">{{ $expense->is_recurring ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-2">{{ $expense->project_or_department ?? '—' }}</td>
                        <td class="px-4 py-2">
                            @if ($expense->invoice_file)
                                <a href="{{ asset('/public/storage/' . $expense->invoice_file) }}" class="text-blue-500 hover:underline" target="_blank">View</a>
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
