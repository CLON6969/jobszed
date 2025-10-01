@extends('layouts.subscription')


@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Create Budget</h1>

    <form method="POST" action="{{ route('admin.finance.budgets.store') }}" class="space-y-4 bg-white p-6 shadow rounded-lg">
        @csrf

        @include('admin.finance.budgets.form', ['budget' => null])

        <button type="submit" class="btn btn-primary">Save Budget</button>
    </form>
</div>
@endsection
