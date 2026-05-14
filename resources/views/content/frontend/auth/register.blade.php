@extends('layouts.frontend')
@section('title', 'Sign Up - Canvato')
@section('page-css')
<link rel="stylesheet" href="{{ asset('canvato/assets/css/auth.css') }}">
<script src="https://unpkg.com/lucide@latest"></script>
@endsection
@section('content')
    <div class="auth-page">
        <div class="auth-visual">
            <img src="{{ asset('canvato/assets/images/auth_bg.png') }}" alt="Canvato Premium Design">
            <div class="auth-visual-overlay"></div>
            <div class="auth-visual-content">
                <span class="auth-visual-tag">Series 01 / Join</span>
                <h2 class="auth-visual-title">Build the<br>Next<br>Generation.</h2>
                <p class="text-muted">Start your journey with the world's most advanced design asset ecosystem.</p>
            </div>
        </div>

        <div class="auth-content">
            <a href="{{ route('frontend.home') }}" class="back-to-site">
                <i data-lucide="arrow-left" style="width: 16px;"></i> Back to site
            </a>
            <div class="auth-container">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="header-logo mb-6" style="font-size: 1.5rem; letter-spacing: 0.1em; color: var(--text-primary); font-family: var(--font-display);">CANVATO.</div>
                        <h1 class="auth-title">Create Account</h1>
                        <p class="auth-subtitle">Join the professional creative network.</p>
                    </div>

                    @if($errors->any())
                    <div style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                        @foreach($errors->all() as $error)
                        <p style="color: #ff4444; margin: 0; font-size: 13px;">{{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <form class="auth-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-input" placeholder="Alex Rivers" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" placeholder="name@company.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••" required>
                        </div>
                        <div class="form-footer">
                            <label class="checkbox-group">
                                <input type="checkbox" required>
                                <span>I agree to the <a href="#" class="auth-link">Terms of Service</a></span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary auth-button">Initialize Account</button>
                    </form>

                    <div class="social-auth">
                        <div class="social-divider"><span>Or sign up with</span></div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <button class="social-btn"><img src="https://www.svgrepo.com/show/355037/google.svg" width="18" alt="Google"> Google</button>
                            <button class="social-btn"><img src="https://www.svgrepo.com/show/341847/github.svg" width="18" alt="Github" style="filter: invert(1);"> Github</button>
                        </div>
                    </div>
                </div>
                <div class="auth-footer-links">
                    Already have an account? <a href="{{ route('login') }}" class="auth-link">Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
<script>lucide.createIcons();</script>
@endsection
