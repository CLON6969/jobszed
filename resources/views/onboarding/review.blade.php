{{-- resources/views/onboarding/review.blade.php --}}
<style>
/* Modern Responsive Resume Theme - Refined */
.resume-container {
    max-width: 950px;
    margin: 2rem auto;
    padding: 2rem;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    background: #ffffff;
    color: #222;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    border-radius: 16px;
    transition: all 0.3s ease;
}

.resume-header {
    text-align: center;
    margin-bottom: 2rem;
}

.resume-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #1f2937;
}

.resume-header .contact {
    font-size: 1rem;
    color: #4b5563;
    line-height: 1.6;
    word-wrap: break-word;
}

.resume-header .contact a {
    color: #2563eb;
    text-decoration: none;
}

.resume-header .contact a:hover {
    text-decoration: underline;
}

.resume-divider {
    border-top: 2px solid #e5e7eb;
    margin: 2rem 0;
}

.resume-section {
    margin-bottom: 2rem;
}

.resume-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 0.5rem;
}

.resume-info-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Always 4 per row on desktop */
    gap: 1rem 2rem;
}

.resume-info-item {
    display: flex;
    flex-direction: column;
}

.resume-info-item strong {
    color: #374151;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.resume-wrap {
    word-break: break-word;
    white-space: pre-wrap;
    margin-top: 0.5rem;
    color: #4b5563;
}

.btn {
    border-radius: 6px;
    font-size: 1rem;
    padding: 0.6rem 1.5rem;
    font-weight: 500;
}

.btn-outline-secondary {
    border: 1px solid #9ca3af;
    color: #374151;
    background-color: transparent;
}

.btn-outline-secondary:hover {
    background-color: #f3f4f6;
    border-color: #6b7280;
}

.btn-success {
    background-color: #10b981;
    color: #ffffff;
}

.btn-success:hover {
    background-color: #059669;
}

/* Responsive */
@media (max-width: 1024px) {
    .resume-info-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 per row on tablets */
    }
}

@media (max-width: 640px) {
    .resume-container {
        padding: 1.5rem;
    }
    .resume-header h1 {
        font-size: 2rem;
    }
    .resume-section-title {
        font-size: 1.1rem;
    }
    .resume-info-grid {
        grid-template-columns: 1fr; /* 1 per row on mobile */
    }
}
.resume-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    text-align: center; /* Center the title text */
    position: relative;
}

/* Add a horizontal line below the centered text */
.resume-section-title::after {
    content: "";
    display: block;
    width: 60px; /* length of the line */
    height: 2px;
    background-color: #f3f4f6;
    margin: 6px auto 0; /* auto centers the line below the text */
}

@media print {
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: #fff;
        color: #000;
    }

    .resume-container {
        box-shadow: none;
        border-radius: 0;
        margin: 0;
        padding: 1rem;
        width: 100%;
    }

    /* Force 4 columns on print */
    .resume-info-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 1rem 2rem;
        page-break-inside: avoid;
    }

    /* Optional: prevent grid items from breaking across pages */
    .resume-info-item {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    /* Hide buttons when printing */
    .btn, a[href] {
        display: none;
    }

    .resume-section-title::after {
        background-color: #000; /* darker line in print */
    }
}


</style>
@extends('onboarding.layout')


@section('form')

<div class=" resume-info-grid">
  <h2 class="text-xl font-semibold mb-4">Review</h2>
  <button type="button" class="btn btn-outline-secondary mb-4" onclick="printResume()">Print Resume</button>
</div>


 <div class="resume-container">

    <!-- Header -->
    <div class="resume-header">
        <h1>{{ $user->name ?? 'Applicant' }} </h1>

        <div class="contact resume-wrap">
            {{ $profile->address }}@if($profile->postal_code) | {{ $profile->postal_code }}@endif<br>
            <strong>Linkedin:</strong> <a href="{{ $profile->linkedin_url }}" target="_blank">{{ $profile->linkedin_url }}</a>
        </div>
    </div>

    <div class="resume-divider"></div>

    <!-- Personal Details -->
    <div class="resume-section">
        <div class="resume-section-title">Personal Details</div>
        <div class="resume-info-grid">
            <div class="resume-info-item"><strong>National ID</strong>{{ $profile->national_id }}</div>
            <div class="resume-info-item"><strong>Gender</strong>{{ ucfirst($profile->gender) }}</div>
            <div class="resume-info-item"><strong>Date of Birth</strong>{{ $profile->date_of_birth }}</div>
            <div class="resume-info-item"><strong>Nationality</strong>{{ $profile->nationality }}</div>
            <div class="resume-info-item"><strong>Years of Experience</strong>{{ $profile->years_of_experience }}</div>
        </div>
        <div class="resume-wrap mt-3"><strong>Professional Summary:</strong><br>{{ $profile->professional_summary }}</div>
    </div>

    <!-- Experience -->
    <div class="resume-section">
        <div class="resume-section-title">Experience</div>
        <div class="resume-info-grid">
            <div class="resume-info-item"><strong>Employer</strong>{{ $experience->employer ?? '-' }}</div>
            <div class="resume-info-item"><strong>Job Title</strong>{{ $experience->job_title ?? '-' }}</div>
            <div class="resume-info-item"><strong>Start Date</strong>{{ $experience->start_date ?? '-' }}</div>
            <div class="resume-info-item"><strong>End Date</strong>{{ $experience->end_date ?? '-' }}</div>
        </div>
    </div>

    <!-- Education -->
    <div class="resume-section">
        <div class="resume-section-title">Education</div>
        <div class="resume-info-grid">
            <div class="resume-info-item"><strong>Level</strong>{{ $education->level ?? '-' }}</div>
            <div class="resume-info-item"><strong>Field of Study</strong>{{ $education->field_of_study ?? '-' }}</div>
        </div>
    </div>

    <!-- Certification -->
    <div class="resume-section">
        <div class="resume-section-title">Certification</div>
        <div class="resume-info-grid">
            <div class="resume-info-item"><strong>Name</strong>{{ $certification->name ?? '-' }}</div>
            <div class="resume-info-item"><strong>Type</strong>{{ $certification->certification_type ?? '-' }}</div>
            <div class="resume-info-item"><strong>Organization</strong>{{ $certification->issuing_organization ?? '-' }}</div>
            <div class="resume-info-item"><strong>Status</strong>{{ $certification->status ?? '-' }}</div>
            
        </div>
    </div>

    <!-- Voluntary Disclosures -->
    <div class="resume-section">
        <div class="resume-section-title">Voluntary Disclosures</div>
        <div class="resume-info-grid">
            <div class="resume-info-item"><strong>Disability Status</strong>{{ $disclosure->disability_status ?? '-' }}</div>
            <div class="resume-info-item"><strong>Ethnicity</strong>{{ $disclosure->ethnicity ?? '-' }}</div>
            <div class="resume-info-item"><strong>Gender Identity</strong>{{ $disclosure->gender_identity ?? '-' }}</div>
            <div class="resume-info-item"><strong>Veteran Status</strong>{{ $disclosure->is_veteran ? 'Yes' : 'No' }}</div>
        </div>
    </div>

    <div class="resume-divider"></div>


 </div>

     <form method="POST" action="{{ route('onboarding.submit') }}" class="mt-4 d-flex justify-content-between flex-wrap gap-2">
        @csrf
        <a href="{{ route('onboarding.step5') }}" class="btn btn-outline-secondary">Previous</a>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    
<h1 class="text-sm">Kumoyo</h1>

<script>
function printResume() {
    // Grab only the resume container
    const resumeContent = document.querySelector('.resume-container').outerHTML;

    // Open a new window for printing
    const printWindow = window.open('', '', 'height=800,width=800');
    printWindow.document.write('<html><head><title>Print Resume</title>');

    // Copy your page styles so it prints correctly
    const styles = Array.from(document.querySelectorAll('style, link[rel="stylesheet"]'))
                         .map(node => node.outerHTML)
                         .join('');
    printWindow.document.write(styles);

    printWindow.document.write('</head><body>');
    printWindow.document.write(resumeContent);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>


    
@endsection