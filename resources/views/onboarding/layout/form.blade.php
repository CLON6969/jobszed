@extends('onboarding.base')

@section('form')
<h2 class="text-xl font-semibold mb-4">Personal Information</h2>
<form method="POST" action="{{ route('onboarding.step1') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block mb-1 font-medium">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full border rounded px-3 py-2" />
    </div>
    <div>
        <label class="block mb-1 font-medium">Address</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}" required class="w-full border rounded px-3 py-2" />
    </div>
    <div>
        <label class="block mb-1 font-medium">Date of Birth</label>
        <input type="date" name="dob" value="{{ old('dob', $user->dob) }}" required class="w-full border rounded px-3 py-2" />
    </div>
    <div>
        <label class="block mb-1 font-medium">Gender</label>
        <select name="gender" class="w-full border rounded px-3 py-2" required>
            <option value="">Select Gender</option>
            @foreach(['Male', 'Female', 'Other'] as $gender)
                <option value="{{ $gender }}" {{ old('gender', $user->gender) == $gender ? 'selected' : '' }}>
                    {{ $gender }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block mb-1 font-medium">Short Bio</label>
        <textarea name="bio" class="w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
    </div>
    <div class="flex justify-between">
        <div></div>
        <button class="bg-blue-600 text-white px-5 py-2 rounded">Next</button>
    </div>
</form>
@endsection