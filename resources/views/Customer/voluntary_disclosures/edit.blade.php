@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Voluntary Disclosure</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('user.applicant.voluntary_disclosures.update', $vd->id ?? 0) }}">
        @csrf
        @method('PUT')

        @include('user.applicant.voluntary_disclosures.form')

        <button type="submit" class="btn btn-success">Save</button>
        
    </form>
</div>
@endsection
