<div class="experience-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="experiences[{{ $index }}][id]" value="{{ $experience['id'] ?? '' }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label>Title</label>
            <input type="text" name="experiences[{{ $index }}][title]" class="form-control" 
                value="{{ $experience['title'] ?? '' }}" required>
        </div>
        <div class="col-md-5">
            <label>Description</label>
            <input type="text" name="experiences[{{ $index }}][description]" class="form-control" 
                value="{{ $experience['description'] ?? '' }}" required>
        </div>
        <div class="col-md-2">
            <label>Required?</label>
            <select name="experiences[{{ $index }}][is_required]" class="form-control">
                <option value="1" {{ (!empty($experience['is_required']) && $experience['is_required'] == 1) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (empty($experience['is_required']) || $experience['is_required'] == 0) ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-experience">X</button>
        </div>
    </div>
</div>
