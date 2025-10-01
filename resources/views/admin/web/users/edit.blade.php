@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit User</h2>
    @include('admin.web.users.partials.form', ['user' => $user])
</div>
@endsection
