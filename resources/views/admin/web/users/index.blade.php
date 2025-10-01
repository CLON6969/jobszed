@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Users</h2>
    <a href="{{ route('admin.web.users.create') }}" class="btn btn-primary mb-3">+ Add User</a>

    @foreach ($users as $user)
        <div class="card mb-2 p-3">
            <h5>{{ $user->name }} ({{ $user->email }})</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.web.users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.web.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $users->links() }}
</div>
@endsection
