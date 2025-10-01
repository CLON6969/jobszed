@extends('layouts.admin_dashboard2')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">✏️ Edit Navigation Item</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.web.general.nav1.update', $navItem->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $navItem->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input type="text" name="name_url" class="form-control" value="{{ $navItem->name_url }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Parent Navigation (optional)</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- None --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ $navItem->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success">💾 Update</button>
                <a href="{{ route('admin.web.general.nav1.index') }}" class="btn btn-secondary">⬅ Back</a>
            </form>
        </div>
    </div>
</div>
@endsection
