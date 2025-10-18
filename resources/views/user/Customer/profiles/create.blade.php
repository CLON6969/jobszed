@extends('layouts.base')

@section('title', 'Create Profile')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-2xl font-bold mb-6">Create Profile</h1>

    <form action="{{ route('user.applicant.profiles.store') }}" method="POST" class="space-y-4">
        @csrf

        @include('user.applicant.profiles.partials.form-fields')

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
            Save
        </button>
    </form>
</div>
@endsection
