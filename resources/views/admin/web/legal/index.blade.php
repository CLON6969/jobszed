@extends('layouts.admin')

@section('content')
<div class="container py-5">
    <h1>Legal Documents</h1>

    <a href="{{ route('admin.web.legal.create') }}" class="btn btn-primary mb-3">+ Create New Document</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($documents as $doc)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5>{{ $doc->title }}</h5>
                <div>
                    <a href="{{ route('admin.web.legal.edit', $doc->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.web.legal.destroy', $doc->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this document?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>No legal documents found.</p>
    @endforelse
</div>
@endsection
