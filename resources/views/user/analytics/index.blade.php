@extends('layouts.seller')
@section('title', 'Analytics')

@section('seller-content')
<h1 class="text-2xl font-semibold mb-4">Analytics Overview</h1>

<div class="grid grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold">Views</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $views }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold">Inquiries</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $inquiries }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold">Sales</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $sales }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold">Conversion Rate</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $conversion_rate }}%</p>
    </div>
</div>
@endsection
