@extends('layouts.frontend')
@section('title', 'My Orders - Canvato')
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
      <h1 class="page-title">Order Repository</h1>
      <p class="page-subtitle">Historical log of all asset initializations and purchases.</p>
    </header>

    <div class="premium-table-container">
      <table class="premium-table">
        <thead>
          <tr>
            <th>Access ID</th>
            <th>Initialization Date</th>
            <th>Asset Name</th>
            <th>Valuation</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="font-family: var(--font-mono); font-size: 12px; color: var(--accent-color);">#ORD-7742</td>
            <td>May 01, 2026</td>
            <td style="font-weight: 600;">Dark Dashboard UI Kit</td>
            <td>$49.00</td>
            <td><span class="status-badge status-completed">Initialized</span></td>
            <td><a href="order-detail.html" class="auth-link">Access Details</a></td>
          </tr>
          <tr>
            <td style="font-family: var(--font-mono); font-size: 12px; color: var(--accent-color);">#ORD-7741</td>
            <td>April 28, 2026</td>
            <td style="font-weight: 600;">3D Icon Sculpture Pack</td>
            <td>$39.00</td>
            <td><span class="status-badge status-completed">Initialized</span></td>
            <td><a href="order-detail.html" class="auth-link">Access Details</a></td>
          </tr>
          <tr>
            <td style="font-family: var(--font-mono); font-size: 12px; color: var(--accent-color);">#ORD-7738</td>
            <td>April 15, 2026</td>
            <td style="font-weight: 600;">Editorial Font Library</td>
            <td>$19.00</td>
            <td><span class="status-badge status-pending">In Transit</span></td>
            <td><a href="order-detail.html" class="auth-link">Access Details</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

  @include('_partials.frontend.footer')
@endsection
@section('page-scripts')
<script>
  lucide.createIcons();
</script>@endsection
