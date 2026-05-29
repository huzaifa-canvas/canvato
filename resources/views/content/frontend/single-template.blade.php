@extends('layouts.frontend')
@section('title', $template->title . ' - Canvato')
@section('page-css')
  <style>
    :root {
      --accent-color: #c22ef5;
      --accent-hover: #b026e0;
      --bg-darker: #0c0c0c;
      --bg-dark: #141414;
      --border-light: rgba(255, 255, 255, 0.1);
    }

    body {
      background-color: var(--bg-darker);
      color: var(--text-primary);
    }

    .product-header-section {
      padding: 140px 0 60px;
      background: radial-gradient(circle at top left, #1a0033 0%, var(--bg-darker) 100%);
      border-bottom: 1px solid var(--border-color);
    }

    .breadcrumb {
      display: flex;
      gap: 10px;
      font-family: var(--font-mono);
      font-size: 12px;
      color: var(--text-secondary);
      text-transform: uppercase;
      margin-bottom: 30px;
      align-items: center;
    }

    .breadcrumb a {
      color: var(--text-secondary);
      text-decoration: none;
    }

    .breadcrumb a:hover {
      color: var(--accent-color);
    }

    .breadcrumb svg {
      width: 10px;
      opacity: 0.5;
    }

    .product-title {
      font-size: clamp(36px, 5vw, 64px);
      margin-bottom: 20px;
      color: var(--text-primary);
      letter-spacing: -0.02em;
      font-weight: 800;
      line-height: 1.1;
    }

    .product-subtitle {
      max-width: 800px;
      color: var(--text-secondary);
      font-size: 1.1rem;
      line-height: 1.7;
    }

    .product-main {
      padding: 80px 0;
    }

    .product-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr;
      gap: 60px;
    }

    @media (max-width: 1024px) {
      .product-grid {
        grid-template-columns: 1fr;
      }
    }

    .product-gallery {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .main-image {
      width: 100%;
      height: 600px;
      background: #000;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .main-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top;
    }

    .main-image img {
      aspect-ratio: 1.5/1;
      object-fit: cover;
      transition: 15s;
      object-position: top;
    }

    .main-image:hover img,
    .main-image.mobile-hovered img {
      object-position: bottom center;
    }

    .thumbnail-strip {
      display: flex;
      gap: 15px;
      overflow-x: auto;
      padding-bottom: 10px;
    }

    .thumbnail {
      width: 120px;
      height: 90px;
      border-radius: 8px;
      overflow: hidden;
      border: 2px solid transparent;
      cursor: pointer;
      opacity: 0.6;
      transition: all 0.3s ease;
    }

    .thumbnail.active,
    .thumbnail:hover {
      opacity: 1;
      border-color: var(--accent-color);
    }

    .thumbnail img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top;
    }

    .product-sidebar {
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .pricing-box {
      background: var(--bg-dark);
      border: 1px solid var(--border-light);
      border-radius: 16px;
      padding: 30px;
    }

    .pricing-box h4 {
      font-size: 16px;
      margin-bottom: 20px;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }

    .license-option {
      border: 1px solid var(--border-light);
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .license-option.selected {
      border-color: var(--accent-color);
      background: rgba(194, 46, 245, 0.05);
    }

    .license-price {
      font-family: var(--font-mono);
      font-size: 18px;
      font-weight: 700;
      color: #fff;
    }

    .btn-cart {
      width: 100%;
      height: 56px;
      background: var(--accent-color);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-family: var(--font-display);
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-cart:hover {
      background: var(--accent-hover);
    }

    .accordion-item {
      border-top: 1px solid var(--border-light);
      overflow: hidden;
    }

    .accordion-item:last-child {
      border-bottom: 1px solid var(--border-light);
    }

    .accordion-header {
      padding: 22px 0;
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      background: transparent !important;
      border: none;
      width: 100%;
      color: var(--text-primary);
      text-align: left;
      outline: none;
    }

    .accordion-header::after {
      content: '+';
      font-size: 18px;
      color: var(--text-secondary);
    }

    .accordion-item.active .accordion-header::after {
      content: '-';
      color: var(--accent-color);
    }

    .accordion-content {
      display: none;
      padding-bottom: 20px;
      color: var(--text-secondary);
      line-height: 1.7;
    }

    .accordion-item.active .accordion-content {
      display: block;
    }

    .tags-list,
    .features-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }

    .features-list li {
      width: 100%;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .features-list li svg {
      width: 16px;
      height: 16px;
      color: var(--accent-color);
    }

    .tags-list li {
      background: rgba(255, 255, 255, 0.05);
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 11px;
      border: 1px solid var(--border-light);
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .tabs-section {
      padding: 80px 0;
      border-top: 1px solid var(--border-light);
    }

    .tabs-nav {
      display: flex;
      gap: 40px;
      border-bottom: 1px solid var(--border-light);
      margin-bottom: 50px;
    }

    .tab-btn {
      background: transparent !important;
      border: none;
      color: var(--text-secondary);
      font-size: 16px;
      font-weight: 700;
      padding: 0 0 25px 0;
      cursor: pointer;
      position: relative;
    }

    .tab-btn.active {
      color: var(--accent-color) !important;
    }

    .tab-btn.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--accent-color);
    }

    .tab-pane {
      display: none;
    }

    .tab-pane.active {
      display: block;
    }
  </style>
@endsection

@section('content')
  @include('_partials.frontend.header')

  <main>
    <section class="product-header-section">
      <div class="container">
        <div class="breadcrumb">
          <a href="{{ route('frontend.home') }}">Home</a>
          <svg viewBox="0 0 320 512" fill="currentColor">
            <path
              d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
          </svg>
          <a href="{{ route('frontend.templates') }}">Templates</a>
          <svg viewBox="0 0 320 512" fill="currentColor">
            <path
              d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
          </svg>
          @if ($template->category)
            <a
              href="{{ route('frontend.templates', ['category' => $template->category->slug]) }}">{{ $template->category->name }}</a>
            <svg viewBox="0 0 320 512" fill="currentColor">
              <path
                d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z" />
            </svg>
          @endif
          <span>{{ $template->title }}</span>
        </div>

        <h1 class="product-title">{{ $template->title }}</h1>
        <p class="product-subtitle">
          {{ $template->short_description ?? 'A premium creative design asset ready to accelerate your workflow.' }}</p>
      </div>
    </section>

    <section class="product-main">
      <div class="container">
        <div class="product-grid">

          <!-- Left: Gallery -->
          <div class="product-gallery">
            <div class="main-image">
              @if ($template->main_thumbnail)
                <a id="main-image-link" href="{{ asset('storage/' . $template->main_thumbnail) }}" target="_blank" onclick="if(window.innerWidth <= 992 && !this.closest('.main-image').classList.contains('mobile-hovered')) { this.closest('.main-image').classList.add('mobile-hovered'); return false; }" style="display:block; width:100%; height:100%; cursor:pointer;">
                  <img id="main-image-display" src="{{ asset('storage/' . $template->main_thumbnail) }}" alt="{{ $template->title }}">
                </a>
              @else
                <a id="main-image-link" href="https://images.unsplash.com/photo-1541462608143-67571c6738dd?auto=format&fit=crop&w=1200&h=800&q=80" target="_blank" onclick="if(window.innerWidth <= 992 && !this.closest('.main-image').classList.contains('mobile-hovered')) { this.closest('.main-image').classList.add('mobile-hovered'); return false; }" style="display:block; width:100%; height:100%; cursor:pointer;">
                  <img
                    id="main-image-display"
                    src="https://images.unsplash.com/photo-1541462608143-67571c6738dd?auto=format&fit=crop&w=1200&h=800&q=80"
                    alt="Main Product Preview">
                </a>
              @endif
            </div>
            <div class="thumbnail-strip">
              @if (is_array($template->thumbnail) && count($template->thumbnail) > 0)
                @foreach ($template->thumbnail as $index => $thumb)
                  <div class="thumbnail {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $thumb) }}" alt="Thumb {{ $index + 1 }}">
                  </div>
                @endforeach
              @elseif($template->main_thumbnail)
                <div class="thumbnail active">
                  <img src="{{ asset('storage/' . $template->main_thumbnail) }}" alt="Thumb 1">
                </div>
              @else
                <div class="thumbnail active">
                  <img src="https://images.unsplash.com/photo-1541462608143-67571c6738dd?auto=format&fit=crop&w=400&h=300&q=80" alt="Thumb 1">
                </div>
              @endif
            </div>
          </div>

          <!-- Right: Sidebar -->
          <div class="product-sidebar">

            @if ($template->price > 0)
              <div class="pricing-box">
                <h4>Pricing:</h4>
                <div class="license-option selected">
                  <div class="license-info">
                    <span class="license-name">Standard License</span>
                  </div>
                  <div class="license-price">
                    ${{ number_format($template->price, 2) }}
                  </div>
                </div>
              </div>
            @endif

            <div class="pricing-box action-buttons">
              @if ($template->price <= 0)
                @if (auth()->check())
                  <a href="{{ route('download.secure', $template->slug) }}" class="btn-cart"
                    style="background: #28a745; text-decoration: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                      <polyline points="7 10 12 15 17 10"></polyline>
                      <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Download Free
                  </a>
                @else
                  <a href="{{ route('login') }}" class="btn-cart" style="background: #28a745; text-decoration: none;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2">
                      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                      <polyline points="7 10 12 15 17 10"></polyline>
                      <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Login to Download
                  </a>
                @endif
              @elseif(auth()->check() && auth()->user()->hasPurchased($template))
                <a href="{{ route('download.secure', $template->slug) }}" class="btn-cart"
                  style="background: #28a745; text-decoration: none;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7 10 12 15 17 10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                  </svg>
                  Download Source Files
                </a>
              @else
                <a href="{{ route('checkout.show', $template->slug) }}" class="btn-cart" style="text-decoration: none;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  Purchase Now
                </a>
              @endif
            </div>

            <div class="accordion-container">
              <div class="accordion-item active">
                <button class="accordion-header">Template Details</button>
                <div class="accordion-content">
                  <p><strong>Released:</strong> {{ $template->created_at->format('F Y') }}</p>
                  @if ($template->meta_data)
                    @foreach ($template->meta_data as $key => $value)
                      @if ($key !== 'compatible_tools')
                        <p><strong>{{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}:</strong>
                          {{ is_array($value) ? implode(', ', $value) : $value }}</p>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>

              @if (isset($template->meta_data['compatible_tools']) && count($template->meta_data['compatible_tools']) > 0)
                <div class="accordion-item">
                  <button class="accordion-header">Compatible Tools</button>
                  <div class="accordion-content">
                    <ul class="features-list">
                      @foreach ($template->meta_data['compatible_tools'] as $tool)
                        <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"></polyline>
                          </svg> {{ $tool }}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              @endif

              @if ($template->tags->count() > 0)
                <div class="tags-section" style="margin-top: 24px; padding-top: 24px; border-top: 1px solid var(--border-light);">
                  <h4 style="font-size: 14px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-primary); margin-bottom: 16px;">Tags</h4>
                  <ul class="tags-list">
                    @foreach ($template->tags as $tag)
                      <li>{{ $tag->name }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tabs Section -->
    <section class="tabs-section">
      <div class="container">
        <div class="tabs-nav">
          <button class="tab-btn active" data-tab="description">Description</button>
        </div>
        <div id="description" class="tab-pane active">
          <div class="tab-content-area text-secondary" style="line-height: 1.8;">
            {!! nl2br(e($template->description ?? 'No detailed description available.')) !!}
          </div>
        </div>
      </div>
    </section>

  </main>

  @include('_partials.frontend.footer')
@endsection

@section('page-script')
  <script>
    // Accordion Toggle using Event Delegation for reliability
    document.addEventListener('click', function(e) {
      const header = e.target.closest('.accordion-header');
      if (header) {
        const item = header.closest('.accordion-item');
        if (item) {
          item.classList.toggle('active');
        }
      }
    });

    // Gallery Image Swapping
    const mainImageDisplay = document.getElementById('main-image-display');
    const mainImageLink = document.getElementById('main-image-link');
    const thumbnails = document.querySelectorAll('.thumbnail-strip .thumbnail img');
    const thumbnailWrappers = document.querySelectorAll('.thumbnail-strip .thumbnail');

    thumbnails.forEach((thumb, index) => {
      // Add cursor pointer to thumbnails so user knows they are clickable
      thumb.style.cursor = 'pointer';
      
      thumb.addEventListener('click', () => {
        // Update Main Image source and link
        const newSrc = thumb.getAttribute('src');
        mainImageDisplay.setAttribute('src', newSrc);
        mainImageLink.setAttribute('href', newSrc);

        // Update active class on thumbnails
        thumbnailWrappers.forEach(wrapper => wrapper.classList.remove('active'));
        thumbnailWrappers[index].classList.add('active');
      });
    });

  </script>
@endsection
