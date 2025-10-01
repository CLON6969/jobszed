@extends('layouts.subscription')

@section('title', 'View Expense')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Expense Details</h1>

    <div class="bg-white p-6 rounded shadow">
        <p><strong>Title:</strong> {{ $expense->title }}</p>
        <p><strong>Amount:</strong> ${{ number_format($expense->amount, 2) }}</p>
        <p><strong>Category:</strong> {{ $expense->category ?? 'N/A' }}</p>
        <p><strong>Date:</strong> {{ $expense->date }}</p>
        <p><strong>Notes:</strong> {{ $expense->notes ?? 'None' }}</p>
        <p><strong>Submitted By:</strong> {{ $expense->user->name ?? 'N/A' }}</p>
    </div>

    <div class="mt-4 space-x-2">
        <a href="{{ route('admin.finance.expenses.edit', $expense) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
        <a href="{{ route('admin.finance.expenses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
    </div>
</div>
@endsection
