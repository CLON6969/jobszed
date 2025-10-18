<div class="skill-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="skills[{{ $index }}][id]" value="{{ $skill->id ?? '' }}">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label>Skill Name</label>
            <input type="text" name="skills[{{ $index }}][name]" class="form-control"
                   placeholder="e.g., CSS, HTML"
                  value="{{ $skill['name'] ?? '' }}" required>
        </div>
        <div class="col-md-3">
            <label>Type</label>
            <select name="skills[{{ $index }}][type]" class="form-control" required>
                <option value="">Select type</option>
                <option value="Soft" {{ ($skill->type ?? '') == 'Soft' ? 'selected' : '' }}>Soft</option>
                <option value="Hard" {{ ($skill->type ?? '') == 'Hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>
        <div class="col-md-3">
            <label>Required?</label>
            <select name="skills[{{ $index }}][is_required]" class="form-control" required>
                <option value="1" {{ ($skill->is_required ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ ($skill->is_required ?? 0) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-skill">Remove</button>
        </div>
    </div>
</div>
