@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Invoice</h1>

    <form method="POST" action="{{ route('admin.finance.invoices.update', $invoice) }}" class="space-y-4 bg-white p-6 shadow rounded-lg">
        @csrf
        @method('PUT')

        @include('admin.finance.invoices.form', ['invoice' => $invoice])

        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>
@endsection
