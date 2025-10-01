{{-- resources/views/onboarding/step2.blade.php --}}
@extends('onboarding.layout')

@section('form')
<h2 class="text-xl font-semibold mb-4">Step 2: Work Experience</h2>
<form method="POST" action="{{ route('onboarding.postStep2') }}" class="space-y-4">
  @csrf

  <input type="hidden" name="experience_id" value="{{ $experience->id ?? '' }}">

  <label>Employer *</label>
  <input type="text" name="employer" value="{{ old('employer', $experience->employer ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>Job Title *</label>
  <input type="text" name="job_title" value="{{ old('job_title', $experience->job_title ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>Start Date *</label>
  <input type="date" name="start_date" value="{{ old('start_date', $experience->start_date ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>End Date</label>
  <input type="date" name="end_date" value="{{ old('end_date', $experience->end_date ?? '') }}" class="w-full border rounded px-3 py-2" />

  <div class="flex justify-between">
    <a href="{{ route('onboarding.step1') }}" class="text-gray-600 hover:underline">Previous</a>
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next & Save</button>
  </div>
</form>
@endsection
