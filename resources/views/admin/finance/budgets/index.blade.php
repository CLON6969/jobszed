@extends('layouts.subscription')


@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Budgets</h1>
    <a href="{{ route('admin.finance.budgets.create') }}" class="btn btn-primary mb-4">+ New Budget</a>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 font-semibold text-gray-600">
                <tr>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Category</th>
                    <th class="p-3 text-left">Date Range</th>
                    <th class="p-3 text-left">Assigned To</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($budgets as $budget)
                <tr class="border-t">
                    <td class="p-3">{{ $budget->id }}</td>
                    <td class="p-3">${{ number_format($budget->amount, 2) }}</td>
                    <td class="p-3">{{ $budget->category ?? '-' }}</td>
                    <td class="p-3">{{ $budget->start_date }} to {{ $budget->end_date }}</td>
                    <td class="p-3">{{ $budget->user?->name ?? '—' }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.finance.budgets.show', $budget) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('admin.finance.budgets.edit', $budget) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.finance.budgets.destroy', $budget) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete this budget?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $budgets->links() }}
        </div>
    </div>
</div>
@endsection
