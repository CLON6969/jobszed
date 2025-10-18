@extends('layouts.base')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900"><i class="fa-solid fa-circle-info"></i></h1>
            <p class="text-gray-500 text-sm mt-1">.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">Profile</span>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div id="statusAlert" class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="document.getElementById('statusAlert').classList.add('hidden')">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Global Error Alert -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Update Form -->
    <form method="POST" action="{{ route('user.applicant.profiles.update', $profile) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')



            <!-- Right: Form Fields -->
            <div class="md:col-span-3 bg-white rounded-2xl p-6 shadow-md space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-3">Personal Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold">Recruitment Status</label>
                        <input type="text" name="recruitment_status"
                               value="{{ old('recruitment_status', $profile->recruitment_status) }}"
                               class="w-full border rounded p-2">
                        @error('recruitment_status') <p class="text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold">Date of Birth</label>
                        <input type="date" name="date_of_birth"
                               value="{{ old('date_of_birth', $profile->date_of_birth) }}"
                               class="w-full border rounded p-2">
                        @error('date_of_birth') <p class="text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold">National ID</label>
                        <input type="text" name="national_id"
                               value="{{ old('national_id', $profile->national_id) }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-semibold">Gender</label>
                        <select name="gender" class="w-full border rounded p-2">
                            <option value="male" @selected(old('gender', $profile->gender) === 'male')>Male</option>
                            <option value="female" @selected(old('gender', $profile->gender) === 'female')>Female</option>
                            <option value="other" @selected(old('gender', $profile->gender) === 'other')>Other</option>
                        </select>
                        @error('gender') <p class="text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold">Nationality</label>
                        <input type="text" name="nationality"
                               value="{{ old('nationality', $profile->nationality) }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-semibold">Postal Code</label>
                        <input type="text" name="postal_code"
                               value="{{ old('postal_code', $profile->postal_code) }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">Address</label>
                        <textarea name="address" rows="2" class="w-full border rounded p-2">{{ old('address', $profile->address) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">LinkedIn URL</label>
                        <input type="url" name="linkedin_url"
                               value="{{ old('linkedin_url', $profile->linkedin_url) }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-semibold">Years of Experience</label>
                        <input type="number" name="years_of_experience"
                               value="{{ old('years_of_experience', $profile->years_of_experience) }}"
                               class="w-full border rounded p-2">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold">Professional Summary</label>
                        <textarea name="professional_summary" rows="4"
                                  class="w-full border rounded p-2">{{ old('professional_summary', $profile->professional_summary) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded flex items-center shadow">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('profileImage').src = e.target.result;
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
