        @php 
    $logo = App\Models\Logo::first();
@endphp

@extends('layouts.sigin')
@section('content')

  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #0a1a3f, #0e2c5d); /* dark bluish gradient */
      color: #e2e8f0;
    }

    .body-img {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      z-index: -1;
     
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      max-width: 450px;
    }

    .login-box {
      background: rgba(10, 25, 61, 0.85);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
      width: 100%;
      backdrop-filter: blur(4px);
      text-align: center;
      color: #f1f5f9;
      border: 1px solid rgba(255, 255, 255, 0.15);
    }

    h2 {
      font-size: 18px;
      margin: 10px 0;
      color: #93c5fd; /* soft blue heading */
    }

    p {
      font-size: 14px;
      color: #cbd5e0;
    }

    .input-group {
      margin-bottom: 15px;
      text-align: left;
    }

    label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
      color: #a3bffa;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper input {
      width: 100%;
      padding: 10px 40px;
      border-radius: 8px;
      border: 1px solid #334155;
      background: rgba(255, 255, 255, 0.08);
      color: #f1f5f9;
      outline: none;
    }

    .icon {
      position: absolute;
      left: 12px;
      color: #60a5fa; /* blue icon */
    }

    i{
        color:#ffffffa7;
    }

    .login-button {
      width: 100%;
      padding: 12px;
      background: #2563eb;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .login-button:hover {
      background: #1d4ed8;
    }

    .signup-text {
      margin-top: 15px;
      font-size: 14px;
      color: #cbd5e0;
    }

    .signup-text a {
      color: #60a5fa;
      text-decoration: none;
    }

    .signup-text a:hover {
      color: #93c5fd;
      text-decoration: underline;
    }

    .footer {
      font-family: 'Orbitron', monospace;
      font-size: 12px;
      margin-top: 20px;
      color: #64748b;
    }

    .alert-success {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      font-size: 14px;
    }

    .alert-error {
      color: #f87171;
      font-size: 13px;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <!-- Optional blurred background -->
  <img class="body-img" src="{{ asset('/public/uploads/pics/'  . $logo->background_picture) }}" alt="background">

  <div class="login-container">
    <div class="login-box">
      <div class="text-center">
                <a href="{{$logo->home_url}}">
                    <img src="{{ asset('/public/uploads/pics/' . $logo->picture) }}" alt="logo" style="width:40px;">
                </a>
        <h2>Forgot your password?</h2>
        <p>Enter your email address and we’ll send you a reset link.</p>
      </div>

      <!-- Laravel Session Status -->
      @if (session('status'))
        <div class="alert-success">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="input-group">
          <label for="email">Email Address</label>
          <div class="input-wrapper">
            <span class="icon"><i class="far fa-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
          </div>
          @error('email')
            <p class="alert-error">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="login-button">Send Reset Link</button>
      </form>

      <div class="signup-text">
        <p>Remembered your password? <a href="{{ route('login') }}">Back to Login</a></p>
      </div>

      <div class="footer">
        <p>  &copy; {{ date('Y') }} Powered by Kumoyo Technologies.</p>
      </div>
    </div>
  </div>
@endsection
