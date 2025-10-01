@php 
    $logo = App\Models\Logo::first();
@endphp

@extends('layouts.sigin')

@section('content')
<div class="body">
    <img class="body-img" src="{{ asset('/public/uploads/pics/'  . $logo->background_picture) }}" alt="background">

    <div class="login-container">
        <div class="login-box">
            <div class="text-center">
                <a href="{{ $logo->home_url }}">
                    <img src="{{ asset('/public/uploads/pics/' . $logo->picture) }}" alt="logo">
                </a>
                <h2>Reset Your Password</h2>
                <p>Enter your new password to secure your account.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Hidden Email Field -->
                <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

                <!-- New Password Field -->
                <div class="input-group">
                    <label>New Password</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" placeholder="New Password" required autocomplete="new-password">
                        <span id="togglePassword" class="toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="alert-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="input-group">
                    <label>Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        <span id="togglePasswordConfirm" class="toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password_confirmation')
                        <span class="alert-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-button">Reset Password</button>

                <p class="signup-text">Remembered your password? <a href="{{ route('login') }}">Back to Login</a></p>

                <p class="footer">© 2025 Powered by Kumoyo Technologies.</p>
            </form>
        </div>
    </div>

    <!-- View Password Script -->
    <script>
        // Toggle New Password
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Toggle Confirm Password
        document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
            const passwordField = document.getElementById('password_confirmation');
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</div>
@endsection
