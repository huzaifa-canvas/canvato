@extends('layouts.frontend')
@section('title', 'Order Detail - Canvato')
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

  <!-- Main Dashboard Content -->
  <main class="container">
    <header style="margin-bottom: 64px; padding-top: 50px;">
      <a href="orders.html"
        style="display: flex; align-items: center; gap: 8px; color: var(--text-secondary); text-decoration: none; font-family: var(--font-mono); font-size: 10px; text-transform: uppercase; margin-bottom: 24px;">
        <i data-lucide="arrow-left" style="width: 12px;"></i>
        Return to History
      </a>
      <h1 class="page-title">Initialization #ORD-7742</h1>
      <p class="page-subtitle">Confirmed on May 01, 2026</p>
    </header>

    <div class="detail-grid">
      <div class="premium-card">
        <div
          style="display: flex; gap: 32px; align-items: flex-start; padding-bottom: 32px; border-bottom: 1px solid var(--card-border);">
          <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?auto=format&fit=crop&w=160&q=80"
            alt="Product"
            style="width: 120px; height: 120px; border-radius: 16px; object-fit: cover; border: 1px solid var(--card-border);">
          <div style="flex: 1;">
            <h4 style="font-size: 1.5rem; margin-bottom: 8px;">Dark Dashboard UI Kit</h4>
            <p class="text-muted" style="font-size: 0.9375rem;">Premium Figma Template â€¢ Creative Unlimited License</p>
            <div style="margin-top: 24px; display: flex; gap: 16px;">
              <button class="btn btn-primary" style="padding: 12px 24px; font-size: 11px;">Download Asset</button>
              <button class="btn"
                style="padding: 12px 24px; font-size: 11px; border: 1px solid var(--card-border); background: transparent;">View
                License</button>
            </div>
          </div>
        </div>

        <div style="margin-top: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
          <div>
            <h5 class="premium-label">Price Breakdown</h5>
            <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px;">
              <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                <span class="text-muted">Item Subtotal</span>
                <span>$49.00</span>
              </div>
              <div
                style="display: flex; justify-content: space-between; font-size: 1.125rem; font-weight: 700; color: var(--accent-color); margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--card-border);">
                <span>Total Valuation</span>
                <span>$49.00</span>
              </div>
            </div>
          </div>
          <div>
            <h5 class="premium-label">Access Token</h5>
            <p
              style="font-family: var(--font-mono); font-size: 11px; background: rgba(255,255,255,0.03); padding: 16px; border-radius: 8px; border: 1px dashed var(--card-border); margin-top: 16px;">
              CV-7742-XP-990-2026
            </p>
          </div>
        </div>
      </div>

      <aside>
        <div class="premium-card" style="padding: 32px;">
          <h5 class="premium-label">Entity Information</h5>
          <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 24px;">
            <div>
              <div style="font-size: 10px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 8px;">
                Studio Address</div>
              <p style="font-size: 0.9375rem; line-height: 1.6;">Alex Rivers<br>Atelier 742<br>Brooklyn, NY 11201</p>
            </div>
            <div>
              <div style="font-size: 10px; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 8px;">
                Method</div>
              <div style="display: flex; align-items: center; gap: 12px; font-size: 0.9375rem;">
                <i data-lucide="credit-card" style="width: 16px; color: var(--accent-color);"></i>
                <span>Visa ending in 4422</span>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <!-- Main Footer -->
  <footer class="footer border-t border-light" id="main-footer" style="margin-top: 120px;">
    <div class="container footer-grid">
      <div class="footer-col brand-col">
        <h3 class="footer-brand font-display text-4xl">CANVATO.</h3>
        <p class="text-muted mt-4 text-sm">Empowering creators with premium design assets.</p>
      </div>
      <div class="footer-col">
        <h4 class="micro-label mb-6">MARKETPLACE</h4>
        <a href="#">UI Kits</a>
        <a href="#">3D Illustrations</a>
        <a href="#">Wireframes</a>
      </div>
      <div class="footer-col">
        <h4 class="micro-label mb-6">COMPANY</h4>
        <a href="#">About</a>
        <a href="#">Careers</a>
        @include('_partials.frontend.footer')
      @endsection
      @section('page-scripts')
      <script>
        lucide.createIcons();
      </script>@endsection
