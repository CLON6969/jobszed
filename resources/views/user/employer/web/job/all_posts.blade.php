@extends('layouts.app')

<style>
    /* job-posts.css */

    /* --- Reset & base font --- */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9fafb;
        color: #1f2937;
        margin: 0;
        padding: 0;
    }

    /* --- Container --- */
    .container {
        max-width: 1024px;
        margin: 2rem auto;
        padding: 1.5rem;
        background-color: #ffffff;
        border-radius: 0.75rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    /* --- Headings --- */
    h4 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        color: #111827;
    }

    /* --- Buttons --- */
    .btn {
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
        user-select: none;
        font-weight: 600;
        color: white;
        background-color: #3b82f6; /* blue */
        display: inline-block;
        text-align: center;
    }

    .btn:hover,
    .btn:focus {
        background-color: #2563eb;
        outline: none;
    }

    .btn-sm {
        font-size: 0.75rem;
        padding: 0.3rem 0.75rem;
    }

    /* Button variants */
    .btn-info {
        background-color: #0ea5e9;
    }

    .btn-info:hover,
    .btn-info:focus {
        background-color: #0284c7;
    }

    .btn-danger {
        background-color: #ef4444;
    }

    .btn-danger:hover,
    .btn-danger:focus {
        background-color: #dc2626;
    }

    /* --- Table Styling --- */
    .table-container {
        overflow-x: auto;
        border-radius: 0.5rem;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    .job-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border-radius: 0.5rem;
        overflow: hidden;
        min-width: 950px; /* widened for actions column */
    }

    .job-table thead {
        background-color: #f3f4f6;
        font-weight: 700;
        color: #374151;
    }

    .job-table th,
    .job-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .job-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .job-table tbody tr:hover,
    .job-table tbody tr:focus-within {
        background-color: #f9fafb;
        outline: none;
        cursor: default;
    }

    /* Accessibility for keyboard focus */
    .job-table tbody tr:focus {
        outline: 2px solid #2563eb;
        outline-offset: 2px;
    }

    /* Badge styles */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 9999px;
        text-transform: capitalize;
        user-select: none;
    }

    .bg-success {
        background-color: #dcfce7;
        color: #166534;
    }

    .bg-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }

    /* Empty text styling */
    .empty-text {
        font-style: italic;
        color: #9ca3af;
    }

    /* Action buttons wrapper inside table */
    .action-buttons {
       
        gap: 0.5rem;
        flex-wrap: nowrap;
       
    }

    .action-buttons form {
        margin: 0;
    }

    /* --- Modal Overlay --- */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        inset: 0;
        background: rgba(0,0,0,0.6);
        overflow-y: auto;
        padding: 2rem 1rem;
        align-items: center;
        justify-content: center;
    }

    .modal[aria-hidden="false"] {
        display: flex;
    }

    .modal-content {
        background: #fff;
        max-width: 600px;
        width: 100%;
        border-radius: 1rem;
        padding: 2rem 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #1f2937;
        max-height: 80vh;
        overflow-y: auto;
        user-select: text;
    }

    .modal-content h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.25rem;
    }

    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: none;
        font-size: 2rem;
        font-weight: 700;
        color: #374151;
        cursor: pointer;
        line-height: 1;
        transition: color 0.2s ease;
        user-select: none;
    }

    .modal-close:hover,
    .modal-close:focus {
        color: #ef4444;
        outline: none;
    }

    .modal-body {
        margin-top: 1rem;
        font-size: 1rem;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    /* --- Responsive --- */
    @media (max-width: 768px) {
        .container {
            margin: 1rem;
            padding: 1rem;
        }
        .job-table {
            min-width: 600px;
        }
    }

    @media (max-width: 480px) {
        .job-table {
            min-width: unset;
            font-size: 0.85rem;
        }

        .btn {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .modal-content {
            padding: 1.25rem 1.5rem;
            max-width: 90vw;
        }
    }
</style>

@section('content')
<div class="container">
    <h4>All Job Posts</h4>

    {{-- Filter form (simplified example) --}}
    <form method="GET" action="{{ route('user.employer.web.job.allPosts') }}" class="filters-form" aria-label="Filter job posts">
        <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
            <input type="text" name="title" placeholder="Title" value="{{ request('title') }}" style="flex:1; min-width: 150px; padding:0.4rem; border-radius:0.375rem; border:1px solid #d1d5db;">
            <select name="department" style="flex:1; min-width: 150px; padding:0.4rem; border-radius:0.375rem; border:1px solid #d1d5db;">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                <option value="{{ $dept }}" @selected(request('department') == $dept)>{{ $dept }}</option>
                @endforeach
            </select>
            <select name="employment_type" style="flex:1; min-width: 150px; padding:0.4rem; border-radius:0.375rem; border:1px solid #d1d5db;">
                <option value="">All Employment Types</option>
                @foreach($employmentTypes as $type)
                <option value="{{ $type }}" @selected(request('employment_type') == $type)>{{ $type }}</option>
                @endforeach
            </select>
            <input type="date" name="deadline_from" value="{{ request('deadline_from') }}" style="padding:0.4rem; border-radius:0.375rem; border:1px solid #d1d5db;">
            <input type="date" name="deadline_to" value="{{ request('deadline_to') }}" style="padding:0.4rem; border-radius:0.375rem; border:1px solid #d1d5db;">
            <button type="submit" class="btn">Filter</button>
            <a href="{{ route('user.employer.web.job.allPosts') }}" class="btn btn-info">Reset</a>
        </div>
    </form>

    @if($posts->count())
    <div class="table-container" tabindex="0" aria-label="Job Posts Table">
        <table class="job-table" role="grid">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Department</th>
                    <th scope="col">Employment Type</th>
                    <th scope="col">Location</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Responsibilities</th>
                    <th scope="col">Benefits</th>
                    <th scope="col">Skills</th>
                    <th scope="col">Experience</th>
                    <th scope="col">Qualifications</th>
                    <th scope="col">Questions</th>
                    <th scope="col" style="min-width:120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $job)
                <tr tabindex="0">
                    <td class="font-semibold" data-label="Title">{{ $job->title }}</td>
                    <td data-label="Department">{{ $job->department }}</td>
                    <td data-label="Employment Type">{{ $job->employment_type }}</td>
                    <td data-label="Location">{{ $job->location }}, {{ $job->country }}</td>
                    <td data-label="Deadline">{{ \Carbon\Carbon::parse($job->application_deadline)->format('Y-m-d') }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $job->status === 'open' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </td>

                    {{-- Description button --}}
                    <td data-label="Description">
                        @if($job->description)
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Description for {{ $job->title }}"
                            data-content="{{ e($job->description) }}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Responsibilities button --}}
                    <td data-label="Responsibilities">
                        @if($job->responsibilities)
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Responsibilities for {{ $job->title }}"
                            data-content="{{ e($job->responsibilities) }}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Benefits button --}}
                    <td data-label="Benefits">
                        @if($job->benefits)
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Benefits for {{ $job->title }}"
                            data-content="{{ e($job->benefits) }}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Skills button --}}
                    <td data-label="Skills">
                        @if($job->skills->count())
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Skills for {{ $job->title }}"
                            data-content="{!! nl2br(e($job->skills->map(fn($s) => $s->name . ($s->is_required ? ' (Required)' : ''))->join("\n"))) !!}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Experiences button --}}
                    <td data-label="Experience">
                        @if($job->experiences->count())
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Experience for {{ $job->title }}"
                            data-content="{!! nl2br(e($job->experiences->map(fn($e) => $e->title . ($e->is_required ? ' (Required)' : ''))->join("\n"))) !!}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Qualifications button --}}
                    <td data-label="Qualifications">
                        @if($job->qualifications->count())
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Qualifications for {{ $job->title }}"
                            data-content="{!! nl2br(e($job->qualifications->map(fn($q) => $q->title . ($q->is_required ? ' (Required)' : ''))->join("\n"))) !!}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Questions button --}}
                    <td data-label="Questions">
                        @if($job->questions->count())
                        <button
                            class="btn btn-info btn-sm open-modal-btn"
                            data-title="Questions for {{ $job->title }}"
                            data-content="{!! nl2br(e($job->questions->map(fn($q) => $q->question . ($q->required ? ' (Required)' : ''))->join("\n"))) !!}">
                            View
                        </button>
                        @else
                        <em class="empty-text">None</em>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td data-label="Actions" class="action-buttons">
                        <a href="{{ route('user.employer.web.job.edit', $job->id) }}" class="btn btn-info btn-sm" aria-label="Edit job {{ $job->title }}">Edit</a>

                        <form method="POST" action="{{ route('user.employer.web.job.destroy', $job->id) }}" onsubmit="return confirm('Are you sure you want to delete this job post?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" aria-label="Delete job {{ $job->title }}">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-container" role="navigation" aria-label="Pagination Navigation" style="margin-top: 1rem;">
        {{ $posts->withQueryString()->links() }}
    </div>
    @else
    <div class="alert alert-info" role="alert">No job posts found.</div>
    @endif
</div>

{{-- Modal overlay --}}
<div id="content-modal" class="modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-title" tabindex="-1">
    <div class="modal-content" role="document">
        <button class="modal-close" aria-label="Close modal">&times;</button>
        <h3 id="modal-title"></h3>
        <div id="modal-body" class="modal-body"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('content-modal');
    const modalTitle = modal.querySelector('#modal-title');
    const modalBody = modal.querySelector('#modal-body');
    const closeBtn = modal.querySelector('.modal-close');

    // Open modal handler
    document.querySelectorAll('.open-modal-btn').forEach(button => {
        button.addEventListener('click', () => {
            modalTitle.textContent = button.getAttribute('data-title');
            modalBody.innerHTML = button.getAttribute('data-content');
            modal.setAttribute('aria-hidden', 'false');
            modal.focus();
            document.body.style.overflow = 'hidden'; // prevent background scroll
        });
    });

    // Close modal handlers
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
            closeModal();
        }
    });

    function closeModal() {
        modal.setAttribute('aria-hidden', 'true');
        modalTitle.textContent = '';
        modalBody.innerHTML = '';
        document.body.style.overflow = '';
    }
});
</script>
@endsection
