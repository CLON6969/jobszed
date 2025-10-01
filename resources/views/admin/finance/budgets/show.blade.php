@extends('layouts.subscription')


@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Budget Details</h1>

    <div class="bg-white shadow p-6 rounded-lg space-y-4">
        <div><strong>Title:</strong> {{ $budget->title }}</div>
        <div><strong>Amount:</strong> ${{ number_format($budget->amount, 2) }}</div>
        <div><strong>Category:</strong> {{ $budget->category ?? '-' }}</div>
        <div><strong>Start Date:</strong> {{ $budget->start_date }}</div>
        <div><strong>End Date:</strong> {{ $budget->end_date }}</div>
        <div><strong>Assigned User:</strong> {{ $budget->user?->name ?? '—' }}</div>
        <div><strong>Notes:</strong> {{ $budget->notes ?? '—' }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.finance.budgets.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.finance.budgets.edit', $budget) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
