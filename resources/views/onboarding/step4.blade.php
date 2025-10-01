@extends('onboarding.layout')

@section('form')
<h2 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Step 4: Certifications</h2>

<form method="POST" action="{{ route('onboarding.postStep4') }}" class="space-y-6" id="certifications-form" novalidate>
  @csrf

  <div id="certifications-wrapper" class="space-y-4">
    @foreach ($certifications as $index => $certification)
      <div class="certification-entry bg-white border border-gray-300 rounded-lg shadow-sm" data-index="{{ $index }}">
        <button type="button"
          class="toggle-collapse w-full px-5 py-3 bg-black text-white rounded-t-lg flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500"
          aria-expanded="false">
          <span class="font-semibold text-lg truncate max-w-[85%]" title="{{ old("certifications.$index.name", $certification->name ?: 'Untitled Certification') }}">
            {{ old("certifications.$index.name", $certification->name ?: 'Untitled Certification') }}
          </span>
          <span class="collapse-icon transition-transform duration-300">&#9660;</span>
        </button>

        <div class="certification-body p-6 border-t border-blue-500 hidden text-gray-900 space-y-4">
          <input type="hidden" name="certifications[{{ $index }}][id]" value="{{ $certification->id ?? '' }}">

          <label class="block font-medium">Name *</label>
          <input type="text" name="certifications[{{ $index }}][name]" value="{{ old("certifications.$index.name", $certification->name) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

          <label class="block font-medium">Certification Type *</label>
          <input type="text" name="certifications[{{ $index }}][certification_type]" value="{{ old("certifications.$index.certification_type", $certification->certification_type) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

          <label class="block font-medium">Issuing Organization *</label>
          <input type="text" name="certifications[{{ $index }}][issuing_organization]" value="{{ old("certifications.$index.issuing_organization", $certification->issuing_organization) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

          <label class="block font-medium">Registered With Authority *</label>
          <select name="certifications[{{ $index }}][registered_with_authority]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <option value="1" @selected(old("certifications.$index.registered_with_authority", $certification->registered_with_authority) == 1)>Yes</option>
            <option value="0" @selected(old("certifications.$index.registered_with_authority", $certification->registered_with_authority) == 0)>No</option>
          </select>

          <label class="block font-medium">Registration Number</label>
          <input type="text" name="certifications[{{ $index }}][registration_number]" value="{{ old("certifications.$index.registration_number", $certification->registration_number) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

          <label class="block font-medium">Authority Certificate Path</label>
          <input type="file" name="certifications[{{ $index }}][authority_certificate_path]" value="{{ old("certifications.$index.authority_certificate_path", $certification->authority_certificate_path) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

          <label class="block font-medium">Level</label>
          <input type="text" name="certifications[{{ $index }}][level]" value="{{ old("certifications.$index.level", $certification->level) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

          <label class="block font-medium">Status *</label>
          <select name="certifications[{{ $index }}][status]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            <option value="obtained" @selected(old("certifications.$index.status", $certification->status) == 'obtained')>Obtained</option>
            <option value="in_progress" @selected(old("certifications.$index.status", $certification->status) == 'in_progress')>In Progress</option>
          </select>

          <label class="block font-medium">Obtained Date</label>
          <input type="date" name="certifications[{{ $index }}][obtained_date]" value="{{ old("certifications.$index.obtained_date", optional($certification->obtained_date)->format('Y-m-d')) }}"
            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

          <button type="button" class="remove-certification mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition">
            Remove Certification
          </button>
        </div>
      </div>
    @endforeach
  </div>

  <button type="button" id="add-certification" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow mt-6 mb-8 transition">
    + Add Another Certification
  </button>

  <div class="flex justify-between">
    <a href="{{ route('onboarding.step3') }}" class="text-gray-600 hover:underline">← Previous</a>
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow transition">Next & Save</button>
  </div>
</form>

<template id="certification-template">
  <div class="certification-entry bg-white border border-gray-300 rounded-lg shadow-sm" data-index="__INDEX__">
    <button type="button"
      class="toggle-collapse w-full px-5 py-3 bg-black text-white rounded-t-lg flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-blue-500"
      aria-expanded="true">
      <span class="font-semibold text-lg truncate max-w-[85%]" title="New Certification">New Certification</span>
      <span class="collapse-icon transition-transform duration-300 rotate-180">&#9660;</span>
    </button>

    <div class="certification-body p-6 border-t border-blue-500 text-gray-900 space-y-4">
      <input type="hidden" name="certifications[__INDEX__][id]" value="">

      <label class="block font-medium">Name *</label>
      <input type="text" name="certifications[__INDEX__][name]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

      <label class="block font-medium">Certification Type *</label>
      <input type="text" name="certifications[__INDEX__][certification_type]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

      <label class="block font-medium">Issuing Organization *</label>
      <input type="text" name="certifications[__INDEX__][issuing_organization]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />

      <label class="block font-medium">Registered With Authority *</label>
      <select name="certifications[__INDEX__][registered_with_authority]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>

      <label class="block font-medium">Registration Number</label>
      <input type="text" name="certifications[__INDEX__][registration_number]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

      <label class="block font-medium">Authority Certificate Path</label>
      <input type="text" name="certifications[__INDEX__][authority_certificate_path]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

      <label class="block font-medium">Level</label>
      <input type="text" name="certifications[__INDEX__][level]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

      <label class="block font-medium">Status *</label>
      <select name="certifications[__INDEX__][status]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        <option value="obtained">Obtained</option>
        <option value="in_progress">In Progress</option>
      </select>

      <label class="block font-medium">Obtained Date</label>
      <input type="date" name="certifications[__INDEX__][obtained_date]" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />

      <button type="button" class="remove-certification mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded transition">
        Remove Certification
      </button>
    </div>
  </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let index = {{ $certifications->count() ?? 0 }};
  const wrapper = document.getElementById('certifications-wrapper');
  const addBtn = document.getElementById('add-certification');
  const template = document.getElementById('certification-template').innerHTML;

  addBtn.addEventListener('click', () => {
    // Collapse all existing certification bodies
    document.querySelectorAll('.certification-entry').forEach(entry => {
      const btn = entry.querySelector('.toggle-collapse');
      const body = entry.querySelector('.certification-body');
      btn.setAttribute('aria-expanded', 'false');
      body.classList.add('hidden');
      btn.querySelector('.collapse-icon').style.transform = 'rotate(0deg)';
    });

    // Add new certification expanded by default
    let newEntry = template.replace(/__INDEX__/g, index);
    wrapper.insertAdjacentHTML('beforeend', newEntry);
    index++;
  });

  wrapper.addEventListener('click', (e) => {
    // Toggle collapse
    if (e.target.classList.contains('toggle-collapse') || e.target.closest('.toggle-collapse')) {
      const btn = e.target.closest('.toggle-collapse');
      const body = btn.nextElementSibling;
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', !expanded);
      if (expanded) {
        body.classList.add('hidden');
        btn.querySelector('.collapse-icon').style.transform = 'rotate(0deg)';
      } else {
        body.classList.remove('hidden');
        btn.querySelector('.collapse-icon').style.transform = 'rotate(180deg)';
      }
    }

    // Remove certification block
    if (e.target.classList.contains('remove-certification')) {
      const entry = e.target.closest('.certification-entry');
      if (entry) entry.remove();
    }
  });
});
</script>
@endsection
