@php 
    $logo = App\Models\Logo::first(); // Changed from $icons = ... to $logo = ...
@endphp

@extends('layouts.signup')

@section('content')
<div class="body">
    <img class="body-img" src="{{ asset('/public/storage/uploads/logo/'  . $logo->background_picture) }}" alt="background">

    <div class="login-container">
        <div class="login-box">
            <div class="text-center">
                <a href="{{$logo->home_url}}">
                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" alt="logo">
                </a>
                
                <h2>Sign up for Mongutech</h2>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
            
                <input type="hidden" name="role_id" value="4"> {{-- Assuming 3 = User --}}
                <input type="hidden" name="account_type" value="main"> {{-- or 'sub' if registering a subaccount --}}
            
                <!-- Full Name -->
                <div class="input-group">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-user"></i></span>
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                    </div>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Username (New Field) -->
                <div class="input-group">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-at"></i></span>
                        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
                    </div>
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Email -->
                <div class="input-group">
                    <label>Email address</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Password -->
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword('password', this)" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Confirm Password -->
                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password_confirmation" id="confirm-password" placeholder="Confirm Password" required>
                        <span class="toggle-password" onclick="togglePassword('confirm-password', this)" title="Show/Hide">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="input-group checkbox-group">
                    <input type="checkbox" name="terms" id="terms" required>
                    <label for="terms">I agree to the <a href="{{ route('legal.show', 'terms-of-service') }}" target="_blank">Terms of Service</a> and <a href="{{ route('legal.show', 'privacy-policy') }}" target="_blank">Privacy Policy</a></label>
                    @error('terms')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            
                <!-- Submit -->
                <button type="submit" class="login-button">Sign up</button>
            
                <p class="signup-text">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
            </form>
            
            <p class="footer">© 2025 Powered by Kumoyo Technologies.</p>
        </div>
    </div>

    <script>
        // Toggle Password Visibility function
        function togglePassword(fieldId, toggleElement) {
            const passwordField = document.getElementById(fieldId);
            const icon = toggleElement.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Username Suggestion (Optional)
        document.querySelector('input[name="name"]').addEventListener('blur', function() {
            if (!document.querySelector('input[name="username"]').value) {
                const suggestedUsername = this.value.trim()
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '')
                    .substring(0, 15);
                
                if (suggestedUsername) {
                    document.querySelector('input[name="username"]').value = suggestedUsername;
                }
            }
        });
    </script>
</div>

@endsection