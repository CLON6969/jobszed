@extends('layouts.subscription')

@section('title', 'Edit Payment')

@section('content')
<div class="max-w-xl mx-auto mt-6 bg-white p-6 shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Edit Payment #{{ $payment->id }}</h2>

    <form action="{{ route('admin.finance.payments.update', $payment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option value="pending" @selected($payment->status === 'pending')>Pending</option>
                <option value="approved" @selected($payment->status === 'approved')>Approved</option>
                <option value="rejected" @selected($payment->status === 'rejected')>Rejected</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Payment Method</label>
            <input type="text" name="payment_method" value="{{ $payment->payment_method }}" class="w-full border rounded px-3 py-2" readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Reference</label>
            <input type="text" name="reference" value="{{ $payment->reference }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex justify-end">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Payment</button>
        </div>
    </form>
</div>
@endsection
