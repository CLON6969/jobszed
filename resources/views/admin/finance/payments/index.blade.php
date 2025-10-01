
@extends('layouts.subscription')

@section('title', 'All Payments')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-semibold mb-4">Payments Management</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-200 text-left text-sm font-semibold">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">User</th>
                <th class="p-2 border">Amount</th>
                <th class="p-2 border">Method</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Date</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr class="border-t">
                    <td class="p-2 border">{{ $payment->id }}</td>
                    <td class="p-2 border">{{ $payment->user->name ?? 'N/A' }}</td>
                    <td class="p-2 border">{{ number_format($payment->amount, 2) }}</td>
                    <td class="p-2 border capitalize">{{ $payment->payment_method }}</td>
                    <td class="p-2 border">{{ ucfirst($payment->status) }}</td>
                    <td class="p-2 border">{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.finance.payments.show', $payment) }}" class="text-blue-600 hover:underline">View</a> |
                        <a href="{{ route('admin.finance.payments.edit', $payment) }}" class="text-yellow-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">No payments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
