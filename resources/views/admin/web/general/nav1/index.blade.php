@extends('layouts.admin_dashboard2')

@section('content')
<div class="container-fluid py-4">

    {{-- Status Alert --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 px-4 py-3 mt-3 mx-3 rounded-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fa-lg"></i>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h2 class="mb-4">Navigation Management</h2>

    <a href="{{ route('admin.web.general.nav1.create') }}" class="btn btn-primary mb-3">➕ Add Navigation Item</a>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">All Navigation Items</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Parent(belong to)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($navItems as $nav)
                        <tr>
                            <td>{{ $nav->id }}</td>
                            <td>{{ $nav->name }}</td>
                            <td>{{ $nav->name_url }}</td>
                            <td>{{ $nav->parent?->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.web.general.nav1.edit', $nav->id) }}" class="btn btn-sm btn-warning">✏️ Edit</a>
                                <form action="{{ route('admin.web.general.nav1.destroy', $nav->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">🗑 Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No navigation items found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
