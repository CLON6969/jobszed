@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Add Certification</h2>
    <form method="POST" action="{{ route('user.applicant.certifications.store') }}" enctype="multipart/form-data">
        @csrf
        @include('user.applicant.certifications.form')
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('user.applicant.certifications.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
