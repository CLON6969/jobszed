<div class="mb-3">
    <label for="name" class="form-label">Certification Name</label>
    <input type="text" name="name" class="form-control"
           value="{{ old('name', $cert->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="certification_type" class="form-label">Certification Type</label>
    <input type="text" name="certification_type" class="form-control"
           value="{{ old('certification_type', $cert->certification_type ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="issuing_organization" class="form-label">Issuing Organization</label>
    <input type="text" name="issuing_organization" class="form-control"
           value="{{ old('issuing_organization', $cert->issuing_organization ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="registration_number" class="form-label">Registration Number (optional)</label>
    <input type="text" name="registration_number" class="form-control"
           value="{{ old('registration_number', $cert->registration_number ?? '') }}">
</div>

<div class="mb-3">
    <label for="obtained_date" class="form-label">Obtained Date</label>
    <input type="date" name="obtained_date" class="form-control"
           value="{{ old('obtained_date', $cert->obtained_date ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="authority_certificate_path" class="form-label">Upload Certificate</label>
    <input type="file" name="authority_certificate_path" class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">

    @if (!empty($cert->authority_certificate_path))
        <p class="mt-2">
            Current File:
            <a href="{{ asset('storage/'.$cert->authority_certificate_path) }}" target="_blank">
                View Certificate
            </a>
        </p>
    @endif
</div>
