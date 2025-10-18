<div>
    <label class="block font-semibold">Recruitment Status</label>
    <input type="text" name="recruitment_status"
           value="{{ old('recruitment_status', $profile->recruitment_status ?? '') }}"
           class="w-full border rounded p-2">
    @error('recruitment_status') <p class="text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block font-semibold">Date of Birth</label>
    <input type="date" name="date_of_birth"
           value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}"
           class="w-full border rounded p-2">
    @error('date_of_birth') <p class="text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block font-semibold">National ID</label>
    <input type="text" name="national_id"
           value="{{ old('national_id', $profile->national_id ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label class="block font-semibold">Gender</label>
    <select name="gender" class="w-full border rounded p-2">
        <option value="male" @selected(old('gender', $profile->gender ?? '') === 'male')>Male</option>
        <option value="female" @selected(old('gender', $profile->gender ?? '') === 'female')>Female</option>
        <option value="other" @selected(old('gender', $profile->gender ?? '') === 'other')>Other</option>
    </select>
    @error('gender') <p class="text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block font-semibold">Nationality</label>
    <input type="text" name="nationality"
           value="{{ old('nationality', $profile->nationality ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label class="block font-semibold">Address</label>
    <textarea name="address" class="w-full border rounded p-2">{{ old('address', $profile->address ?? '') }}</textarea>
</div>

<div>
    <label class="block font-semibold">Postal Code</label>
    <input type="text" name="postal_code"
           value="{{ old('postal_code', $profile->postal_code ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label class="block font-semibold">LinkedIn URL</label>
    <input type="url" name="linkedin_url"
           value="{{ old('linkedin_url', $profile->linkedin_url ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label class="block font-semibold">Years of Experience</label>
    <input type="number" name="years_of_experience"
           value="{{ old('years_of_experience', $profile->years_of_experience ?? '') }}"
           class="w-full border rounded p-2">
</div>

<div>
    <label class="block font-semibold">Professional Summary</label>
    <textarea name="professional_summary" rows="4"
              class="w-full border rounded p-2">{{ old('professional_summary', $profile->professional_summary ?? '') }}</textarea>
</div>
