@extends('layouts.frontend')
@section('title', 'Checkout: ' . $template->title)

@section('page-css')
<style>
    :root {
        --bg-darker: #0c0c0c;
        --bg-dark: #141414;
        --border-light: rgba(255,255,255,0.1);
        --accent-color: #c22ef5;
    }
    body { background-color: var(--bg-darker); color: #fff; }
    .checkout-container { padding: 120px 0 80px; max-width: 800px; margin: 0 auto; }
    .checkout-box { background: var(--bg-dark); border: 1px solid var(--border-light); border-radius: 16px; padding: 40px; }
    .product-summary { display: flex; gap: 20px; align-items: center; border-bottom: 1px solid var(--border-light); padding-bottom: 20px; margin-bottom: 20px; }
    .product-summary img { width: 120px; border-radius: 8px; }
    .product-details h3 { margin: 0 0 10px 0; font-size: 24px; }
    .product-details .price { font-size: 20px; font-weight: bold; color: var(--accent-color); }
    .btn-pay { width: 100%; padding: 15px; background: var(--accent-color); color: #fff; border: none; border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 20px; }
    .btn-pay:hover { background: #b026e0; }
</style>
@endsection

@section('content')
@include('_partials.frontend.header')

<main class="checkout-container container">
    <div class="checkout-box">
        <h2 class="mb-4">Complete Your Purchase</h2>
        
        <div class="product-summary">
            @if($template->main_thumbnail)
                <img src="{{ asset('storage/' . $template->main_thumbnail) }}" alt="{{ $template->title }}">
            @else
                <img src="https://images.unsplash.com/photo-1541462608143-67571c6738dd?auto=format&fit=crop&w=200&h=200&q=80" alt="Placeholder">
            @endif
            <div class="product-details">
                <h3>{{ $template->title }}</h3>
                <div class="price">${{ number_format($template->price, 2) }}</div>
            </div>
        </div>

        <form action="{{ route('checkout.process', $template->slug) }}" method="POST">
            @csrf
            <p class="text-muted mb-4">Click below to simulate a successful payment and unlock your secure files instantly.</p>
            <button type="submit" class="btn-pay">Pay ${{ number_format($template->price, 2) }}</button>
        </form>
    </div>
</main>

@include('_partials.frontend.footer')
@endsection
