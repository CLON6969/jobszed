@extends('layouts.admin')

@section('title', 'Invoices Report')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">📄 Invoices Report</h2>
        <div class="space-x-2">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Export CSV</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Export PDF</button>
        </div>
    </div>

    {{-- Filters --}}
    @include('admin.finance.reports.partials.filters', [
        'filters' => ['status', 'client', 'date_range']
    ])

    {{-- Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Invoices</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalInvoices }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Outstanding Balance</p>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalBalance }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Paid</p>
            <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $totalPaid }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <p class="text-sm text-gray-500 dark:text-gray-300">Overdue</p>
            <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $totalOverdue }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2">Invoice #</th>
                    <th class="px-4 py-2">Issued To</th>
                    <th class="px-4 py-2">Issued Date</th>
                    <th class="px-4 py-2">Due Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Total</th>
                    <th class="px-4 py-2">Paid</th>
                    <th class="px-4 py-2">Balance</th>
                    <th class="px-4 py-2">Linked Payment(s)</th>
                    <th class="px-4 py-2">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <td class="px-4 py-2">{{ $invoice->invoice_number }}</td>
                        <td class="px-4 py-2">{{ $invoice->client->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $invoice->issued_date }}</td>
                        <td class="px-4 py-2">{{ $invoice->due_date }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-white text-xs bg-{{ $invoice->status_color }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ currency_format($invoice->total_amount, $invoice->currency) }}</td>
                        <td class="px-4 py-2">{{ currency_format($invoice->paid_amount, $invoice->currency) }}</td>
                        <td class="px-4 py-2">{{ currency_format($invoice->balance, $invoice->currency) }}</td>
                        <td class="px-4 py-2">
                            @foreach ($invoice->payments as $payment)
                                <div>{{ $payment->transaction_id }}</div>
                            @endforeach
                        </td>
                        <td class="px-4 py-2">{{ $invoice->notes }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center px-4 py-6 text-gray-500">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>
@endsection


