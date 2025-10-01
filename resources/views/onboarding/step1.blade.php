{{-- resources/views/onboarding/step1.blade.php --}}
@extends('onboarding.layout')

@section('form')
<h2 class="text-xl font-semibold mb-4">Step 1: Personal Information</h2>
<form method="POST" action="{{ route('onboarding.postStep1') }}" class="space-y-4">
  @csrf

  <label>National ID</label>
  <input type="text" name="national_id" value="{{ old('national_id', $profile->national_id ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>Date of Birth *</label>
  <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>Gender *</label>
  <select name="gender" class="w-full border rounded px-3 py-2" required>
    <option value="">Select</option>
    <option value="male" @selected(old('gender', $profile->gender ?? '') == 'male')>Male</option>
    <option value="female" @selected(old('gender', $profile->gender ?? '') == 'female')>Female</option>
    <option value="other" @selected(old('gender', $profile->gender ?? '') == 'other')>Other</option>
  </select>

  <label>Nationality</label>
  <input type="text" name="nationality" value="{{ old('nationality', $profile->nationality ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>Address *</label>
  <input type="text" name="address" value="{{ old('address', $profile->address ?? '') }}" class="w-full border rounded px-3 py-2" required />

  <label>Postal Code</label>
  <input type="text" name="postal_code" value="{{ old('postal_code', $profile->postal_code ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>LinkedIn URL</label>
  <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>Professional Summary</label>
  <textarea name="professional_summary" class="w-full border rounded px-3 py-2">{{ old('professional_summary', $profile->professional_summary ?? '') }}</textarea>

  <label>Years of Experience</label>
  <input type="number" name="years_of_experience" value="{{ old('years_of_experience', $profile->years_of_experience ?? '') }}" class="w-full border rounded px-3 py-2" min="0" />

  <div class="flex justify-between">
    <div></div>
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next & Save</button>
  </div>
</form>
@endsection
