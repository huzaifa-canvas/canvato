@extends('layouts.frontend')
@section('title', 'My Profile - Canvato')
@section('page-css')
  <link rel="stylesheet" href="{{ asset('canvato/assets/css/dashboard.css') }}">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    :root {
      --accent-color: #c22ef5;
      --accent-hover: #b026e0;
    }
  </style>
@endsection
@section('body-class', 'class="dashboard-page"')
@section('content')
  @include('_partials.frontend.header')
  @include('_partials.frontend.dashboard-nav')

  <main class="container">
    <div class="form-section">
      <header style="margin-bottom: 64px; padding-top: 50px;">
        <h1 class="page-title">Personal Studio</h1>
        <p class="page-subtitle">Refine your identity and studio preferences.</p>
      </header>

      @if (session('success'))
        <div
          style="background: rgba(0,255,0,0.1); border: 1px solid rgba(0,255,0,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
          <p style="color: #44ff44; margin: 0; font-size: 13px;">{{ session('success') }}</p>
        </div>
      @endif
      @if ($errors->any())
        <div
          style="background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.3); border-radius: 8px; padding: 12px; margin-bottom: 20px;">
          @foreach ($errors->all() as $error)
            <p style="color: #ff4444; margin: 0; font-size: 13px;">{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <div class="premium-card">
        <form method="POST" action="{{ route('frontend.profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-grid">
            <div class="premium-input-group">
              <label class="premium-label">Display Name</label>
              <input type="text" name="name" class="premium-input" value="{{ old('name', auth()->user()->name) }}"
                placeholder="Full Name">
            </div>
            <div class="premium-input-group">
              <label class="premium-label">Email Address</label>
              <input type="email" name="email" class="premium-input" value="{{ old('email', auth()->user()->email) }}"
                placeholder="Email">
            </div>
          </div>
          <div style="margin-top: 48px; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 20px 48px;">Save Profile</button>
          </div>
        </form>
      </div>

      <div class="premium-card" style="margin-top: 48px;">
        <h2 style="font-size: 1.2rem; margin-bottom: 32px; color: var(--text-primary);">Change Password</h2>
        <form method="POST" action="{{ route('frontend.profile.password') }}">
          @csrf
          @method('PUT')
          <div class="form-grid">
            <div class="premium-input-group">
              <label class="premium-label">Current Password</label>
              <input type="password" name="current_password" class="premium-input" placeholder="••••••••" required>
            </div>
            <div class="premium-input-group">
              <label class="premium-label">New Password</label>
              <input type="password" name="password" class="premium-input" placeholder="••••••••" required>
            </div>
            <div class="premium-input-group">
              <label class="premium-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="premium-input" placeholder="••••••••" required>
            </div>
          </div>
          <div style="margin-top: 48px; display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary" style="padding: 20px 48px;">Update Password</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  @include('_partials.frontend.footer')
@endsection
@section('page-scripts')
<script>
  lucide.createIcons();
</script>@endsection
