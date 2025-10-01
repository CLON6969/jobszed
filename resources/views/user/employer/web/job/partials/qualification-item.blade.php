<div class="qualification-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="qualifications[{{ $index }}][id]" value="{{ $qualification['id'] ?? '' }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label>Title</label>
            <input type="text" name="qualifications[{{ $index }}][title]" class="form-control" 
                value="{{ $qualification['title'] ?? '' }}" required>
        </div>
        <div class="col-md-4">
            <label>Level</label>
            <input type="text" name="qualifications[{{ $index }}][level]" class="form-control" 
                value="{{ $qualification['level'] ?? '' }}">
        </div>
        <div class="col-md-2">
            <label>Required?</label>
            <select name="qualifications[{{ $index }}][is_required]" class="form-control">
                <option value="1" {{ (!empty($qualification['is_required']) && $qualification['is_required'] == 1) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (empty($qualification['is_required']) || $qualification['is_required'] == 0) ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-qualification">Remove</button>
        </div>
    </div>
</div>
