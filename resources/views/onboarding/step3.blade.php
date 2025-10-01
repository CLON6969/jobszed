{{-- resources/views/onboarding/step3.blade.php --}}
@extends('onboarding.layout')

@section('form')
<h2 class="text-xl font-semibold mb-4">Step 3: Education</h2>
<form method="POST" action="{{ route('onboarding.postStep3') }}" class="space-y-4">
  @csrf

  <input type="hidden" name="education_id" value="{{ $education->id ?? '' }}">

  <label>Education Level *</label>
  <input type="text" name="level" value="{{ old('level', $education->level ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>Field of Study *</label>
  <input type="text" name="field_of_study" value="{{ old('field_of_study', $education->field_of_study ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <div class="flex justify-between">
    <a href="{{ route('onboarding.step2') }}" class="text-gray-600 hover:underline">Previous</a>
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next & Save</button>
  </div>
</form>
@endsection
