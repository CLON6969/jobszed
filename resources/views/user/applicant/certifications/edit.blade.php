@extends('layouts.base')

@section('content')
<div class="container mt-4">
    <h2>Edit Certification</h2>
    <form method="POST" action="{{ route('user.applicant.certifications.update', $cert->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('user.applicant.certifications.form', ['cert' => $cert])
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('user.applicant.certifications.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
