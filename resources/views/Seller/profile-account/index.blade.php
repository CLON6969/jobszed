@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-6xl">

    <!-- Header -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-500 text-sm mt-1">Manage your personal information, email, and account settings.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-sm">Profile</span>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session('status') === 'profile-updated')
        <div id="statusAlert" class="bg-green-50 border border-green-200 text-green-700 rounded-lg px-4 py-3 mb-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>Profile updated successfully!</span>
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
    <form id="myForm"  method="POST" action="{{ route('Seller.profile-account.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Left: Profile Card -->
            <div class="bg-white rounded-2xl p-6 shadow-md">
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto">
                        <img id="profileImage"
                             src="{{ Auth::user()->profile_picture ? asset('public/storage/' . Auth::user()->profile_picture) : asset('public/uploads/pics/default1.png') }}"
                             alt="Profile Picture"
                             class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">

                        <label for="profile_picture" class="absolute bottom-1 right-1 bg-blue-600 text-white p-2 rounded-full cursor-pointer shadow hover:bg-blue-700">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="profile_picture" name="profile_picture" class="hidden" onchange="previewImage(event)">
                        </label>
                    </div>

                    <h2 class="text-xl font-semibold mt-4 text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-500 text-sm">{{ ucfirst($user->user_type) }}</p>

                    @error('profile_picture')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profile Completion -->
                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Profile Completion</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $profileCompletion }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $profileCompletion }}% complete</p>
                </div>
            </div>

            <!-- Right: Form Details -->
            <div class="md:col-span-3 bg-white rounded-2xl p-6 shadow-md">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-3">Personal Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="flex items-center gap-2">
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2.5 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed" readonly>
                        @if($user->email_verified_at)
                            <span class="text-green-600 text-xs font-medium bg-green-100 px-2 py-1 rounded-full">Verified</span>
                        @else
                            <span class="text-red-600 text-xs font-medium bg-red-100 px-2 py-1 rounded-full">Unverified</span>
                        @endif
                    </div>
                </div>

                <!-- Phone -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- WhatsApp -->
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
    <input type="text" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}"
           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 @error('whatsapp') border-red-500 @enderror">
    @error('whatsapp')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600 @error('address') border-red-500 @enderror">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City, State, Postal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state', $user->state) }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                    </div>
                </div>

                <!-- Country -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                    <input type="text" name="country" value="{{ old('country', $user->country) }}"
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                </div>

                <!-- Bio -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                    <textarea name="bio" rows="3"
                              class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-blue-600">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="flex justify-end">
    <button type="submit" id="saveBtn"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg flex items-center shadow">
        <span class="btn-text"><i class="fas fa-save mr-2"></i> Save Changes</span>
        <span class="btn-loading hidden">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </span>
    </button>
                </div>
            </div>
        </div>
    </form>
    

    <!-- Email Verification -->
    @if(!$user->email_verified_at)
    <div class="mt-10 bg-white rounded-2xl p-6 shadow-md">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Verify Your Email</h2>
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <p class="text-gray-600 mb-3 md:mb-0">Your email <strong>{{ $user->email }}</strong> is not verified yet.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 shadow">
                    Resend Verification Email
                </button>
            </form>
        </div>
        @if(session('status') === 'verification-link-sent')
            <p class="text-green-600 text-sm mt-2">A new verification link has been sent to your email address.</p>
        @endif
    </div>
    @endif

    <!-- Delete Account -->
    <div class="mt-10 bg-white rounded-2xl p-6 shadow-md">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Delete Account</h2>
        <p class="text-gray-600 mb-4">Once you delete your account, there is no going back. Please be certain.</p>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
            <div class="flex gap-3">
                <i class="fas fa-exclamation-circle text-red-500 mt-1"></i>
                <div>
                    <h3 class="text-sm font-semibold text-red-800">Are you sure you want to delete your account?</h3>
                    <p class="text-sm text-red-700 mt-1">This will permanently delete your account and remove all associated data.</p>
                </div>
            </div>
        </div>

        <button type="button" onclick="openDeleteModal()"
                class="bg-red-600 hover:bg-red-700 text-white font-medium px-6 py-2.5 rounded-lg flex items-center shadow">
            <i class="fas fa-trash-alt mr-2"></i> Delete Account
        </button>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 mx-4">
        <div class="flex justify-between items-center border-b pb-3">
            <h3 class="text-lg font-semibold text-gray-900">Confirm Account Deletion</h3>
            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('Seller.profile-account.destroy') }}" method="POST" target="_top">
            @csrf
            @method('DELETE')

            <p class="text-gray-600 mt-4 mb-3">Enter your password to confirm deletion:</p>
            <input type="password" name="password" required
                   class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2.5 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-medium">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview profile image
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('profileImage').src = e.target.result;
        reader.readAsDataURL(event.target.files[0]);
    }

    // Delete Modal
    function openDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }


        // this is for the save button loading
document.getElementById('myForm').addEventListener('submit', function() {
    let btn = document.getElementById('saveBtn');
    btn.querySelector('.btn-text').classList.add('hidden');   // hide text
    btn.querySelector('.btn-loading').classList.remove('hidden'); // show spinner
    btn.disabled = true; // prevent double clicks
});
</script>
@endsection

