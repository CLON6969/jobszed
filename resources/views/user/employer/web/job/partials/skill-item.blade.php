<div class="skill-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="skills[{{ $index }}][id]" value="{{ $skill['id'] ?? '' }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label>Skill Name</label>
            <input type="text" name="skills[{{ $index }}][name]" class="form-control" 
                value="{{ $skill['name'] ?? '' }}" required>
        </div>

        <div class="col-md-3">
            <label>Type</label>
            <input type="text" name="skills[{{ $index }}][type]" class="form-control" 
                value="{{ $skill['type'] ?? '' }}">
        </div>

        <div class="col-md-3">
            <label>Required?</label>
            <select name="skills[{{ $index }}][is_required]" class="form-control">
                <option value="1" {{ (!empty($skill['is_required']) && $skill['is_required'] == 1) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (empty($skill['is_required']) || $skill['is_required'] == 0) ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm w-100 remove-skill">Remove</button>
        </div>
    </div>
</div>
