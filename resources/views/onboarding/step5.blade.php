{{-- resources/views/onboarding/step5.blade.php --}}
@extends('onboarding.layout')

@section('form')
<h2 class="text-xl font-semibold mb-4">Step 5: Voluntary Disclosures</h2>
<form method="POST" action="{{ route('onboarding.postStep5') }}" class="space-y-4">
  @csrf

  <label>Disability Status *</label>
  <select name="disability_status" class="w-full border rounded px-3 py-2" required>
    <option value="yes" @selected(old('disability_status', $disclosure->disability_status ?? '') == 'yes')>Yes</option>
    <option value="no" @selected(old('disability_status', $disclosure->disability_status ?? '') == 'no')>No</option>
    <option value="prefer_not_to_say" @selected(old('disability_status', $disclosure->disability_status ?? '') == 'prefer_not_to_say')>Prefer not to say</option>
  </select>

  <label>Ethnicity</label>
  <input type="text" name="ethnicity" value="{{ old('ethnicity', $disclosure->ethnicity ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>Gender Identity</label>
  <input type="text" name="gender_identity" value="{{ old('gender_identity', $disclosure->gender_identity ?? '') }}" class="w-full border rounded px-3 py-2" />

  <label>Veteran Status *</label>
  <select name="is_veteran" class="w-full border rounded px-3 py-2" required>
    <option value="1" @selected(old('is_veteran', $disclosure->is_veteran ?? '') == 1)>Yes</option>
    <option value="0" @selected(old('is_veteran', $disclosure->is_veteran ?? '') == 0)>No</option>
  </select>

  <div class="flex justify-between">
    <a href="{{ route('onboarding.step4') }}" class="text-gray-600 hover:underline">Previous</a>
    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next & Save</button>
  </div>
</form>
@endsection
