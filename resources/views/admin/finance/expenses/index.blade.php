@extends('layouts.subscription')

@section('title', 'All Expenses')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Expenses</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">#</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Category</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $expense->title }}</td>
                        <td class="p-3">${{ number_format($expense->amount, 2) }}</td>
                        <td class="p-3">{{ $expense->category ?? '-' }}</td>
                        <td class="p-3">{{ $expense->date }}</td>
                        <td class="p-3">{{ $expense->user->name ?? 'N/A' }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('admin.finance.expenses.show', $expense) }}" class="text-blue-600 hover:underline">View</a>
                            <a href="{{ route('admin.finance.expenses.edit', $expense) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.finance.expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Delete this expense?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $expenses->links() }}
    </div>
</div>
@endsection
