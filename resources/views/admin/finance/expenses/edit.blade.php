@extends('layouts.subscription')

@section('title', 'Edit Expense')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Edit Expense</h1>

    <form action="{{ route('admin.finance.expenses.update', $expense) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Title</label>
            <input type="text" name="title" value="{{ old('title', $expense->title) }}" class="w-full border rounded px-3 py-2">
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Amount</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount', $expense->amount) }}" class="w-full border rounded px-3 py-2">
            @error('amount') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Category</label>
            <input type="text" name="category" value="{{ old('category', $expense->category) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Date</label>
            <input type="date" name="date" value="{{ old('date', $expense->date) }}" class="w-full border rounded px-3 py-2">
            @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-medium">Notes</label>
            <textarea name="notes" rows="4" class="w-full border rounded px-3 py-2">{{ old('notes', $expense->notes) }}</textarea>
        </div>

        <div class="mt-4 flex space-x-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.finance.expenses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
