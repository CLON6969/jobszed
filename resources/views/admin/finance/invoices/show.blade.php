@extends('layouts.subscription')


@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Invoice Details</h1>

    <div class="bg-white shadow p-6 rounded-lg space-y-4">
        <div><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</div>
        <div><strong>Client:</strong> {{ $invoice->client_name }}</div>
        <div><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</div>
        <div><strong>Due Date:</strong> {{ $invoice->due_date }}</div>
        <div><strong>Status:</strong>
            <span class="inline-block px-2 py-1 text-xs rounded {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($invoice->status) }}
            </span>
        </div>
        <div><strong>Notes:</strong> {{ $invoice->notes ?? '—' }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.finance.invoices.edit', $invoice) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
