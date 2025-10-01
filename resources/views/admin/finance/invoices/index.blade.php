@extends('layouts.subscription')


@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Invoices</h1>
    <a href="{{ route('admin.finance.invoices.create') }}" class="btn btn-primary mb-4">+ New Invoice</a>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 font-semibold">
                <tr>
                    <th class="p-3 text-left">Invoice #</th>
                    <th class="p-3 text-left">Client</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Due Date</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr class="border-t">
                    <td class="p-3">{{ $invoice->number }}</td>
                    <td class="p-3">{{ $invoice->user?->name ?? '—' }}</td>
                    <td class="p-3">${{ number_format($invoice->amount, 2) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $invoice->due_date }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.finance.invoices.show', $invoice) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.finance.invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.finance.invoices.destroy', $invoice) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this invoice?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection
