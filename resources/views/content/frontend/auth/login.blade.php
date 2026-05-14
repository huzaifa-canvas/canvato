@extends('layouts.frontend')
@section('title', 'Login - Canvato')
@section('page-css')
<link rel="stylesheet" href="{{ asset('canvato/assets/css/auth.css') }}">
<script src="https://unpkg.com/lucide@latest"></script>
@endsection
@section('content')
    <div class="auth-page">
        <!-- Visual Side -->
        <div class="auth-visual">
            <img src="{{ asset('canvato/assets/images/auth_bg.png') }}" alt="Canvato Premium Design">
            <div class="auth-visual-overlay"></div>
            <div class="auth-visual-content">
                <span class="auth-visual-tag">Series 01 / Auth</span>
                <h2 class="auth-visual-title">Unlock your<br>Creative<br>Potential.</h2>
                <p class="text-muted">Join the elite community of designers and developers building the future of digital interfaces.</p>
            </div>
        </div>

        <!-- Form Side -->
        <div class="auth-content">
            <a href="{{ route('frontend.home') }}" class="back-to-site">
                <i data-lucide="arrow-left" style="width: 16px;"></i>
                Back to site
            </a>

            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="header-logo mb-6" style="font-size: 1.5rem; letter-spacing: 0.1em; color: var(--text-primary); font-family: var(--font-display);">CANVATO.</div>
                        <h1 class="auth-title">Welcome Back</h1>
                        <p class="auth-subtitle">Enter your credentials to access your studio.</p>
                    </div>

                    @if($errors->any())
                    <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                        @foreach($errors->all() as $error)
                        <p style="color: #ff4444; margin: 0; font-size: 13px;">{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <form class="auth-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" placeholder="name@company.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <label class="form-label">Password</label>
                                <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Forgot?</a>
                            </div>
                            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>

                        <div class="form-footer">
                            <label class="checkbox-group">
                                <input type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary auth-button">Initialize Studio</button>
                    </form>

                    <div class="social-auth">
                        <div class="social-divider"><span>Or continue with</span></div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <button class="social-btn">
                                <img src="https://www.svgrepo.com/show/355037/google.svg" width="18" alt="Google"> Google
                            </button>
                            <button class="social-btn">
                                <img src="https://www.svgrepo.com/show/341847/github.svg" width="18" alt="Github" style="filter: invert(1);"> Github
                            </button>
                        </div>
                    </div>
                </div>

                <div class="auth-footer-links">
                    Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign up</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
<script>lucide.createIcons();</script>
@endsection
