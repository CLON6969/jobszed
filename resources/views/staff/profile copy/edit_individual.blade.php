@extends('layouts.update')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Complete Your Company Profile</h2>

    <form method="POST" action="{{ route('user.profile.update') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="name">Company Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <!-- Add more required fields -->
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Save and Continue</button>
    </form>
</div>
@endsection
