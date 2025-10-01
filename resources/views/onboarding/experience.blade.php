


@extends('layouts.base') 

@section('content')
   <!-- STEP 2: My Experience -->
<div class="max-w-3xl mx-auto py-10 px-4">
  <h2 class="text-2xl font-semibold mb-4">Step 2 of 6: My Experience</h2>
  <form method="POST" action="{{ route('onboarding.step2') }}" class="space-y-6">
    @csrf
    <div>
      <label class="block mb-1 font-medium">Most Recent Job Title</label>
      <input type="text" name="title" class="w-full border rounded px-3 py-2" required />
    </div>
    <div>
      <label class="block mb-1 font-medium">Description</label>
      <textarea name="description" rows="4" class="w-full border rounded px-3 py-2"></textarea>
    </div>
    <button class="bg-blue-600 text-white px-5 py-2 rounded">Continue to Application Questions</button>
  </form>
</div>
@endsection

