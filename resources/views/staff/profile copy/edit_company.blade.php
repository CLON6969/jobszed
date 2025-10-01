@extends('layouts.update')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-xl font-semibold mb-4">Update Company Profile</h2>
    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf
        
        <label>Company Name:</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full mb-4"/>

        <label>Username:</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" required class="w-full mb-4"/>

        <label>Email:</label>
        <input type="emaexi$user->website) }}" class="w-full mb-4"/>

        <label>Industry:</label>
        <input type="text" name="industry" value="{{ old('industry', $user->industry) }}" class="w-full mb-4"/>

        <label>Company Registration Number:</label>
        <input type="text" name="company_registration_number" value="{{ old('company_registration_number', $user->company_registration_number) }}" class="w-full mb-4"/>

        <label>Tax ID:</label>
        <input type="text" name="tax_id" value="{{ old('tax_id', $user->tax_id) }}" class="w-full mb-4"/>

        <label>Organization Size:</label>
        <input type="text" name="organization_size" value="{{ old('organization_size', $user->organization_size) }}" class="w-full mb-4"/>

        <label>Business License (PDF or Image):</label>
        <input type="file" name="business_license_path" class="w-full mb-4"/>

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture" class="w-full mb-4"/>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Profile</button>
    </form>
</div>
@endsection
