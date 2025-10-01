@php $isEdit = isset($user); @endphp

<form method="POST" action="{{ $isEdit ? route('admin.web.users.update', $user) : route('admin.web.users.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" value="{{ old('username', $user->username ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
    </div>

    <div class="mb-3">
        <label>Role ID</label>
        <input type="number" name="role_id" class="form-control" value="{{ old('role_id', $user->role_id ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label>{{ $isEdit ? 'New Password (optional)' : 'Password' }}</label>
        <input type="password" name="password" class="form-control" {{ $isEdit ? '' : 'required' }}>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ $isEdit ? '' : 'required' }}>
    </div>

    <button type="submit" class="btn btn-success">{{ $isEdit ? 'Update' : 'Create' }}</button>
</form>
