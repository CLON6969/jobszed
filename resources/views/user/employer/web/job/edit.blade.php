@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h4>Edit Job Post</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.employer.web.job.update', $job) }}" method="POST">
        @csrf
        @method('PUT')

        @include('user.employer.web.job._form', ['job' => $job])

        <button type="submit" class="btn btn-primary mt-3">Update Job</button>
    </form>
</div>
@endsection
