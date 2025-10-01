<div class="mb-3">
    <label for="disability_status" class="form-label">Disability Status</label>
    <input type="text" name="disability_status" id="disability_status" class="form-control" value="{{ old('disability_status', $vd->disability_status ?? '') }}" required>
    @error('disability_status')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="ethnicity" class="form-label">Ethnicity</label>
    <input type="text" name="ethnicity" id="ethnicity" class="form-control" value="{{ old('ethnicity', $vd->ethnicity ?? '') }}" required>
    @error('ethnicity')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="gender_identity" class="form-label">Gender Identity</label>
    <input type="text" name="gender_identity" id="gender_identity" class="form-control" value="{{ old('gender_identity', $vd->gender_identity ?? '') }}" required>
    @error('gender_identity')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="is_veteran" class="form-label">Veteran Status</label>
    <select name="is_veteran" id="is_veteran" class="form-control" required>
        <option value="0" {{ old('is_veteran', $vd->is_veteran ?? '') == 0 ? 'selected' : '' }}>No</option>
        <option value="1" {{ old('is_veteran', $vd->is_veteran ?? '') == 1 ? 'selected' : '' }}>Yes</option>
    </select>
    @error('is_veteran')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
