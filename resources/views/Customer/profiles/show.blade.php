@extends('layouts.base')

@section('title', 'View Profile')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Profile Details</h1>

    <p><strong>Professional Summary:</strong></p>
    <p class="mb-4">{{ $profile->professional_summary }}</p>

    <p><strong>Years of Experience:</strong> {{ $profile->years_of_experience }}</p>

    {{-- Add other fields as needed --}}

    <a href="{{ route('applicant.profile.edit', $profile) }}" class="btn btn-secondary mt-4">Edit Profile</a>
    <a href="{{ route('applicant.profile.index') }}" class="btn btn-link mt-4">Back to Profiles</a>
</div>
@endsection
