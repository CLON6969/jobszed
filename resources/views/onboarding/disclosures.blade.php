
@extends('layouts.base') 

@section('content')
    

<!-- STEP 4: Voluntary Disclosures -->
<div class="max-w-3xl mx-auto py-10 px-4">
  <h2 class="text-2xl font-semibold mb-4">Step 4 of 6: Voluntary Disclosures</h2>
  <form method="POST" action="{{ route('onboarding.step4') }}" class="space-y-6">
    @csrf
    <div>
      <label class="block mb-1 font-medium">Do you have a disability?</label>
      <select name="disability" class="w-full border rounded px-3 py-2">
        <option value="">Select</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
        <option value="prefer_not">Prefer not to say</option>
      </select>
    </div>
    <div>
      <label class="block mb-1 font-medium">Veteran Status</label>
      <select name="veteran_status" class="w-full border rounded px-3 py-2">
        <option value="">Select</option>
        <option value="veteran">Veteran</option>
        <option value="non_veteran">Non-Veteran</option>
        <option value="prefer_not">Prefer not to say</option>
      </select>
    </div>
    <button class="bg-blue-600 text-white px-5 py-2 rounded">Continue to Review</button>
  </form>
</div>

@endsection


