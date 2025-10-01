@extends('layouts.subscription')

@section('content')
<div class="container mx-auto px-4 py-6">

{{-- resources/views/admin/finance/reports/index.blade.php --}}
@include('admin.finance.reports.partials.layout', [
    'title' => 'Finance Overview',
    'summary' => [
        ['label' => 'Total Payments', 'value' => $totalPayments, 'class' => 'bg-payments'],
        ['label' => 'Total Expenses', 'value' => $totalExpenses, 'class' => 'bg-expenses'],
        ['label' => 'Total Budgets', 'value' => $totalBudgets, 'class' => 'bg-budgets'],
        ['label' => 'Unpaid Invoices', 'value' => $unpaidInvoices, 'class' => 'bg-invoices'],
    ],
    'financeData' => [
        'payments' => $totalPayments,
        'invoices' => $unpaidInvoices,
        'expenses' => $totalExpenses,
        'budgets' => $totalBudgets
    ]
])
</div>



@endsection
