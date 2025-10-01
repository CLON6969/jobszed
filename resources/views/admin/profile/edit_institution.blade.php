@extends('layouts.update')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-xl font-semibold mb-4">Update Institution Profile</h2>
    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <label>Institution Name:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full mb-4"/>

        <label>Username:</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full mb-4"/>

        <label>Email:</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full mb-4"/>

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full mb-4"/>

        <label>Website:</label>
        <input type="text" name="website" value="{{ old('website', $user->website) }}" class="w-full mb-4"/>

        <label>Organization Type:</label>
        <input type="text" name="organization_type" value="{{ old('organization_type', $user->organization_type) }}" class="w-full mb-4"/>

        <label>Industry:</label>
        <input type="text" name="industry" value="{{ old('industry', $user->industry) }}" class="w-full mb-4"/>

        <label>Tax ID:</label>
        <input type="text" name="tax_id" value="{{ old('tax_id', $user->tax_id) }}" class="w-full mb-4"/>

        <label>Organization Size:</label>
        <input type="text" name="organization_size" value="{{ old('organization_size', $user->organization_size) }}" class="w-full mb-4"/>

        <label>ID Document (PDF/Image):</label>
        <input type="file" name="id_document_path" class="w-full mb-4"/>

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture" class="w-full mb-4"/>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Profile</button>
    </form>
</div>
@endsection
