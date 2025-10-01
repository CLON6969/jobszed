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
      background: linear-gradient(135deg, #0a1a3f, #0e2c5d);
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
      color: #93c5fd;
    }

    p {
      font-size: 14px;
      color: #cbd5e0;
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
      margin-bottom: 10px;
    }

    .login-button:hover {
      background: #1d4ed8;
    }

    .logout-button {
      background: transparent;
      color: #cbd5e0;
      border: none;
      font-size: 14px;
      cursor: pointer;
      text-decoration: underline;
      transition: color 0.2s;
    }

    .logout-button:hover {
      color: #93c5fd;
    }

    .alert-success {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      font-size: 14px;
    }

    .footer {
      font-family: 'Orbitron', monospace;
      font-size: 12px;
      margin-top: 20px;
      color: #64748b;
    }
  </style>

  <img class="body-img" src="{{ asset('/public/uploads/pics/'  . $logo->background_picture) }}" alt="background">

  <div class="login-container">
    <div class="login-box">
      <div class="text-center">
        <a href="{{$logo->home_url}}">
                    
            <img src="{{ asset('/public/uploads/pics/' . $logo->picture) }}" alt="logo" style="width:40px;">
        </a>
        <h2>Email Verification</h2>
        <p>Thanks for signing up! Before getting started, could you verify your email by clicking the link we just emailed to you? If you didn't receive it, we can send another.</p>
      </div>

      @if (session('status') == 'verification-link-sent')
        <div class="alert-success">
          A new verification link has been sent to your email address.
        </div>
      @endif

      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="login-button">Resend Verification Email</button>
      </form>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-button">Log Out</button>
      </form>

      <div class="footer">
       <p>  &copy; {{ date('Y') }} Powered by Kumoyo Technologies.</p>
      </div>
    </div>
  </div>
@endsection
