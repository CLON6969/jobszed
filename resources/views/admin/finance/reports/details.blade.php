@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">{{ ucfirst($type) }} Report</h2>

    <div class="overflow-x-auto bg-white shadow rounded p-4">
        @includeIf("admin.finance.reports.partials.$type", ['records' => $records])
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
@endsection
