@extends('layouts.subscription')
@section('title', 'Payment Details')

@section('content')
<div class="max-w-2xl mx-auto mt-6 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Payment #{{ $payment->id }}</h2>

    <ul class="space-y-2 text-sm">
        <li><strong>User:</strong> {{ $payment->user->name ?? 'N/A' }}</li>
        <li><strong>Amount:</strong> {{ number_format($payment->amount, 2) }}</li>
        <li><strong>Status:</strong> {{ ucfirst($payment->status) }}</li>
        <li><strong>Method:</strong> {{ ucfirst($payment->payment_method) }}</li>
        <li><strong>Reference:</strong> {{ $payment->reference }}</li>
        <li><strong>Transaction Type:</strong> {{ $payment->transaction_type }}</li>
        <li><strong>Narration:</strong> {{ $payment->narration }}</li>
        <li><strong>Created At:</strong> {{ $payment->created_at->toDayDateTimeString() }}</li>
    </ul>

    @if($payment->bank_proof)
        <div class="mt-4">
            <h4 class="font-medium">Bank Proof:</h4>
            <a href="{{ asset('/public/storage/' . $payment->bank_proof) }}" target="_blank" class="text-blue-500 underline">
                View Uploaded File
            </a>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.finance.payments.edit', $payment) }}" class="text-yellow-600 hover:underline mr-4">Edit Payment</a>
        <a href="{{ route('admin.finance.payments.index') }}" class="text-gray-600 hover:underline">Back to List</a>
    </div>
</div>
@endsection
