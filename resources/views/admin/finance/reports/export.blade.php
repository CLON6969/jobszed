@extends('layouts.admin')

@section('title', '📤 Export Reports')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">📤 Export Hub</h2>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <p class="text-gray-600 dark:text-gray-300 mb-4">Select a report type and format to export financial data.</p>

        <form action="{{ route('admin.finance.reports.export') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                {{-- Report Type --}}
                <div>
                    <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                    <select name="report_type" id="report_type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="payments">Payments</option>
                        <option value="invoices">Invoices</option>
                        <option value="expenses">Expenses</option>
                        <option value="budgets">Budgets</option>
                        <option value="overview">Overview Summary</option>
                    </select>
                </div>

                {{-- Format --}}
                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Export Format</label>
                    <select name="format" id="format"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                        <option value="csv">CSV</option>
                        <option value="pdf">PDF</option>
                        <option value="xlsx">Excel (XLSX)</option>
                    </select>
                </div>

                {{-- Date Range --}}
                <div>
                    <label for="date_range" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date Range (optional)</label>
                    <input type="text" name="date_range" id="date_range"
                        placeholder="YYYY-MM-DD - YYYY-MM-DD"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-white"
                        value="{{ old('date_range') }}">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 shadow-sm">
                    ⬇️ Export Report
                </button>
            </div>
        </form>

        @if(session('success'))
            <div class="mt-6 text-green-700 dark:text-green-400">
                ✅ {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection
