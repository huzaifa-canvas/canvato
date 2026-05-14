@extends('layouts.frontend')
@section('title', 'Checkout - Canvato')
@section('page-css')
<link rel="stylesheet" href="{{ asset('canvato/assets/css/dashboard.css') }}">
<script src="https://unpkg.com/lucide@latest"></script>
<style>:root { --accent-color: #c22ef5; --accent-hover: #b026e0; }</style>
@endsection
@section('body-class', 'class="dashboard-page"')
@section('content')
@include('_partials.frontend.header')
@include('_partials.frontend.dashboard-nav')

    <main class="container">
        <header style="margin-bottom: 64px; padding-top: 50px;">
            <h1 class="page-title">Secure Initialization</h1>
            <p class="page-subtitle">Finalize your acquisition of premium creative assets.</p>
        </header>

        <div class="detail-grid">
            <!-- Left: Checkout Forms -->
            <div>
                <section style="margin-bottom: 64px;">
                    <h2 style="font-size: 1.5rem; text-transform: uppercase; margin-bottom: 32px;">1. Entity Details</h2>
                    <div class="premium-card">
                        <form class="auth-form">
                            <div class="form-grid">
                                <div class="premium-input-group">
                                    <label class="premium-label">Legal First Name</label>
                                    <input type="text" class="premium-input" placeholder="Alex">
                                </div>
                                <div class="premium-input-group">
                                    <label class="premium-label">Legal Last Name</label>
                                    <input type="text" class="premium-input" placeholder="Rivers">
                                </div>
                                <div class="premium-input-group form-full">
                                    <label class="premium-label">Registered Email</label>
                                    <input type="email" class="premium-input" placeholder="alex@studio.com">
                                </div>
                                <div class="premium-input-group form-full">
                                    <label class="premium-label">Billing Residency</label>
                                    <input type="text" class="premium-input" placeholder="742 Studio Lane, Brooklyn, NY">
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

                <section>
                    <h2 style="font-size: 1.5rem; text-transform: uppercase; margin-bottom: 32px;">2. Capital Transfer</h2>
                    <div class="premium-card">
                        <div style="display: flex; flex-direction: column; gap: 32px;">
                            <div style="background: rgba(194, 46, 245, 0.05); padding: 24px; border-radius: 16px; border: 1.5px solid var(--accent-color); display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <i data-lucide="credit-card" style="color: var(--accent-color); width: 24px; height: 24px;"></i>
                                    <span style="font-weight: 700; letter-spacing: 0.05em;">SECURE CARD PROTOCOL</span>
                                </div>
                                <div style="display: flex; gap: 12px; opacity: 0.7;">
                                    <img src="https://www.svgrepo.com/show/303102/visa-logo.svg" height="14" style="filter: invert(1);">
                                    <img src="https://www.svgrepo.com/show/303248/mastercard-2-logo.svg" height="14" style="filter: invert(1);">
                                </div>
                            </div>
                            
                            <form class="auth-form">
                                <div class="premium-input-group">
                                    <label class="premium-label">Card Number</label>
                                    <input type="text" class="premium-input" placeholder="XXXX XXXX XXXX 4422">
                                </div>
                                <div class="form-grid">
                                    <div class="premium-input-group">
                                        <label class="premium-label">Expiration</label>
                                        <input type="text" class="premium-input" placeholder="MM / YY">
                                    </div>
                                    <div class="premium-input-group">
                                        <label class="premium-label">Security Code</label>
                                        <input type="text" class="premium-input" placeholder="CVC">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right: Order Summary -->
            <aside>
                <div class="premium-card" style="position: sticky; top: 140px; padding: 32px;">
                    <h3 style="text-transform: uppercase; font-size: 12px; letter-spacing: 0.15em; margin-bottom: 32px; color: var(--text-secondary);">Acquisition Summary</h3>
                    
                    <div style="display: flex; gap: 20px; margin-bottom: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--card-border);">
                        <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?auto=format&fit=crop&w=100&q=80" alt="Product" style="width: 72px; height: 72px; border-radius: 12px; object-fit: cover; border: 1px solid var(--card-border);">
                        <div style="flex: 1;">
                            <h4 style="font-size: 1rem; margin-bottom: 6px;">Dark Dashboard UI Kit</h4>
                            <div style="font-size: 18px; font-weight: 800; color: var(--accent-color);">$49.00</div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 40px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span class="text-muted">Item Subtotal</span>
                            <span>$49.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.875rem;">
                            <span class="text-muted">Network Fee</span>
                            <span style="font-family: var(--font-mono); color: #00ff84;">$0.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 800; margin-top: 12px; padding-top: 24px; border-top: 1.5px solid var(--card-border);">
                            <span>Total</span>
                            <span style="color: var(--accent-color);">$49.00</span>
                        </div>
                    </div>

                    <button class="btn btn-primary" style="width: 100%; padding: 24px; font-size: 14px;" onclick="window.location.href='orders.html'">Complete Initialization</button>
                    
                    <p style="text-align: center; font-size: 11px; color: var(--text-secondary); margin-top: 32px; line-height: 1.6;">
                        Secure SSL Encryption Enabled.<br>
                        Authorized by Canvato Protocol.
                    </p>
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
@include('_partials.frontend.footer')
@endsection
@section('page-scripts')<script>lucide.createIcons();</script>@endsection
