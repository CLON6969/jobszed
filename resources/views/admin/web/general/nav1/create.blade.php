@extends('layouts.admin_dashboard2')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">➕ Add Navigation Item</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.web.general.nav1.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="name_url" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Navigation (optional)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">✅ Save</button>
                <a href="{{ route('admin.web.general.nav1.index') }}" class="btn btn-secondary">⬅ Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
