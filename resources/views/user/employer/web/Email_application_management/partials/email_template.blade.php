<form id="templateForm">
    @csrf
    @method('PUT')
    <input type="hidden" id="templateId" value="{{ $template->id }}">

    <div class="mb-3">
        <label class="form-label">Subject</label>
        <input type="text" id="templateSubject" class="form-control" value="{{ $template->subject }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Body</label>
        <textarea id="templateBody" class="form-control" rows="6">{{ $template->body }}</textarea>
    </div>

    <button type="button" class="btn btn-primary" id="saveTemplate">Save Template</button>
</form>
