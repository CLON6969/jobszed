@extends('layouts.subscription')


@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Budget</h1>

    <form method="POST" action="{{ route('admin.finance.budgets.update', $budget) }}" class="space-y-4 bg-white p-6 shadow rounded-lg">
        @csrf
        @method('PUT')

        @include('admin.finance.budgets.form', ['budget' => $budget])

        <button type="submit" class="btn btn-primary">Update Budget</button>
    </form>
</div>
@endsection
