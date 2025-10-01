@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4>Create New Job Post</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.web.job.store') }}" method="POST">
        @csrf
        @include('admin.web.job._form', ['job' => null])
        <button type="submit" class="btn btn-success mt-3">Create Job</button>
    </form>
</div>
@endsection
