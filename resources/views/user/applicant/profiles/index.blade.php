@extends('layouts.base')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900"><i class="fa-solid fa-circle-info"></i> My Profile</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your personal information, experience, and professional summary.</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-2">
            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">Overview</span>
            <a href="{{ route('user.applicant.profiles.edit', $profile) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
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

    <!-- Right: Profile Details -->
    <div class="md:col-span-3 bg-white rounded-2xl p-6 shadow-md space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-3">Personal Information</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold text-gray-700">Recruitment Status</label>
                <p class="mt-1 text-gray-900">{{ $profile->recruitment_status ?? '-' }}</p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Date of Birth</label>
                <p class="mt-1 text-gray-900">{{ $profile->date_of_birth ?? '-' }}</p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">National ID</label>
                <p class="mt-1 text-gray-900">{{ $profile->national_id ?? '-' }}</p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Gender</label>
                <p class="mt-1 text-gray-900">{{ ucfirst($profile->gender ?? '-') }}</p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Nationality</label>
                <p class="mt-1 text-gray-900">{{ $profile->nationality ?? '-' }}</p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Postal Code</label>
                <p class="mt-1 text-gray-900">{{ $profile->postal_code ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700">Address</label>
                <p class="mt-1 text-gray-900">{{ $profile->address ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700">LinkedIn URL</label>
                <p class="mt-1 text-blue-600 underline">
                    @if($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" target="_blank">{{ $profile->linkedin_url }}</a>
                    @else
                        -
                    @endif
                </p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Years of Experience</label>
                <p class="mt-1 text-gray-900">{{ $profile->years_of_experience ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <label class="block font-semibold text-gray-700">Professional Summary</label>
                <p class="mt-1 text-gray-900">{{ $profile->professional_summary ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
