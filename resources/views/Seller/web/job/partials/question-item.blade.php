<div class="question-item border rounded p-3 mb-2 bg-light">
    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id ?? '' }}">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label>Question</label>
            <textarea name="questions[{{ $index }}][question]" class="form-control" placeholder="Enter the question here..." required> {{ $question['question'] ?? '' }} </textarea>
        </div>
        <div class="col-md-3">
            <label>Required?</label>
            <select name="questions[{{ $index }}][required]" class="form-control" required>
                <option value="1" {{ ($question->required ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ ($question->required ?? 0) == 0 ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-question">X</button>
        </div>
    </div>
</div>
