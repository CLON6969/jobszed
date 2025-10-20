@extends('layouts.Customer')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded-xl p-6">
    <h2 class="text-2xl font-semibold mb-4">Spending Analytics</h2>

    <p class="text-gray-700 mb-4">
        Total Amount Spent: <span class="font-bold">K{{ number_format($totalSpent, 2) }}</span>
    </p>

    <p class="text-gray-600">
        This is calculated from all your orders on the platform.
    </p>
</div>
@endsection
