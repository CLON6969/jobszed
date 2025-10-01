<div class="question-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question['id'] ?? '' }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-9">
            <label>Question</label>
            <input type="text" name="questions[{{ $index }}][question]" class="form-control" 
                value="{{ $question['question'] ?? '' }}" required>
        </div>
        <div class="col-md-2">
            <label>Required?</label>
            <select name="questions[{{ $index }}][required]" class="form-control">
                <option value="1" {{ (!empty($question['required']) && $question['required'] == 1) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ (empty($question['required']) || $question['required'] == 0) ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove-question">X</button>
        </div>
    </div>
</div>
