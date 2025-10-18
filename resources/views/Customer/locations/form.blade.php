<div class="mb-3">
    <label for="location_id" class="form-label">Location ID</label>
    <input type="number" name="location_id" id="location_id" class="form-control" value="{{ old('location_id', $location->location_id ?? '') }}" required>
    @error('location_id')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>
