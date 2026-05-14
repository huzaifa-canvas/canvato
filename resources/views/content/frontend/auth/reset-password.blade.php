@extends('layouts.frontend')
@section('title', 'Reset Password - Canvato')
@section('page-css')
<link rel="stylesheet" href="{{ asset('canvato/assets/css/auth.css') }}">
<script src="https://unpkg.com/lucide@latest"></script>
@endsection
@section('content')
    <div class="auth-page">
        <div class="auth-visual">
            <img src="{{ asset('canvato/assets/images/auth_bg.png') }}" alt="Canvato">
            <div class="auth-visual-overlay"></div>
            <div class="auth-visual-content">
                <span class="auth-visual-tag">Series 01 / Security</span>
                <h2 class="auth-visual-title">Secure<br>Your<br>Studio.</h2>
            </div>
        </div>
        <div class="auth-content">
            <a href="{{ route('frontend.home') }}" class="back-to-site"><i data-lucide="arrow-left" style="width: 16px;"></i> Back to site</a>
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="header-logo mb-6" style="font-size: 1.5rem; letter-spacing: 0.1em; color: var(--text-primary); font-family: var(--font-display);">CANVATO.</div>
                        <h1 class="auth-title">Reset Password</h1>
                        <p class="auth-subtitle">Enter your new password below.</p>
                    </div>
                    @if($errors->any())
                    <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                        @foreach($errors->all() as $error)<p style="color: #ff4444; margin: 0; font-size: 13px;">{{ $error }}</p>@endforeach
                    </div>
                    @endif
                    <form class="auth-form" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" value="{{ $request->email ?? old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                        </div>
                        <button type="submit" class="btn btn-primary auth-button">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')<script>lucide.createIcons();</script>@endsection
