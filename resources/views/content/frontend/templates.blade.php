@extends('layouts.frontend')
@section('title', 'All Templates - Canvato')
@section('page-css')
    <style>
        /* ═══════════════════════════════════════════════════
           ALL TEMPLATES — ENVATO-STYLE SIDEBAR + GRID
           ═══════════════════════════════════════════════════ */
        :root {
            --accent: #c22ef5;
            --accent-hover: #a51dd4;
            --bg-body: #0a0a0a;
            --bg-card: #141414;
            --bg-sidebar: #111111;
            --border: rgba(255,255,255,0.08);
            --text-1: #ffffff;
            --text-2: rgba(255,255,255,0.55);
            --text-3: rgba(255,255,255,0.35);
            --radius: 12px;
        }

        /* ── Hero ── */
        .tpl-hero {
            padding: 130px 0 50px;
            text-align: center;
            background: radial-gradient(ellipse at top center, rgba(194,46,245,0.12) 0%, var(--bg-body) 70%);
            border-bottom: 1px solid var(--border);
        }
        .tpl-hero .breadcrumb-nav {
            font-size: 12px;
            color: var(--text-3);
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .tpl-hero .breadcrumb-nav a { color: var(--text-2); text-decoration: none; }
        .tpl-hero .breadcrumb-nav a:hover { color: var(--accent); }
        .tpl-hero h1 {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 800;
            color: var(--text-1);
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }
        .tpl-hero h1 span { color: var(--accent); }
        .tpl-hero p {
            color: var(--text-2);
            font-size: 15px;
            max-width: 580px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ── Types Ribbon ── */
        .tpl-types-ribbon {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            overflow-x: auto;
            white-space: nowrap;
        }
        .tpl-types-ribbon::-webkit-scrollbar { display: none; }
        .tpl-type-pill {
            display: inline-block;
            padding: 8px 18px;
            margin-right: 10px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border);
            border-radius: 30px;
            color: var(--text-2);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .tpl-type-pill:hover {
            background: rgba(255,255,255,0.1);
            color: var(--text-1);
        }
        .tpl-type-pill.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 4px 12px rgba(194,46,245,0.3);
        }

        /* ── Search Bar ── */
        .tpl-search-bar {
            padding: 16px 0;
            background: rgba(10,10,10,0.95);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 64px;
            z-index: 90;
        }
        .tpl-search-inner {
            display: flex;
            gap: 12px;
            align-items: center;
            max-width: 700px;
        }
        .tpl-search-input {
            flex: 1;
            height: 44px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0 16px 0 42px;
            color: var(--text-1);
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='rgba(255,255,255,0.3)' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cline x1='21' y1='21' x2='16.65' y2='16.65'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: 14px center;
        }
        .tpl-search-input:focus { border-color: var(--accent); }
        .tpl-search-input::placeholder { color: var(--text-3); }
        .tpl-search-btn {
            height: 44px;
            padding: 0 24px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .tpl-search-btn:hover { background: var(--accent-hover); }

        /* ── Main Layout ── */
        .tpl-layout {
            display: flex;
            gap: 0;
            min-height: 80vh;
        }

        /* ── Sidebar ── */
        .tpl-sidebar {
            width: 260px;
            flex-shrink: 0;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            padding: 28px 24px;
            position: sticky;
            top: 125px;
            height: calc(100vh - 125px);
            overflow-y: auto;
        }
        .tpl-sidebar::-webkit-scrollbar { width: 4px; }
        .tpl-sidebar::-webkit-scrollbar-track { background: transparent; }
        .tpl-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            gap: 6px;
            background: none;
            border: 1px solid var(--border);
            color: var(--text-2);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            margin-bottom: 16px;
        }

        .filter-section { margin-bottom: 28px; }
        .filter-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-2);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .filter-clear {
            font-size: 11px;
            color: var(--accent);
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }
        .filter-clear:hover { text-decoration: underline; }

        /* Category Links */
        .filter-list { list-style: none; padding: 0; margin: 0; }
        .filter-list li { margin-bottom: 2px; }
        .filter-list li a {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            color: var(--text-2);
            text-decoration: none;
            font-size: 13px;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .filter-list li a:hover,
        .filter-list li a.active {
            background: rgba(194,46,245,0.08);
            color: var(--accent);
        }
        .filter-list li a .count {
            font-size: 11px;
            color: var(--text-3);
            background: rgba(255,255,255,0.05);
            padding: 2px 8px;
            border-radius: 10px;
        }

        /* Checkboxes */
        .filter-check { margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .filter-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
            flex-shrink: 0;
        }
        .filter-check label {
            font-size: 13px;
            color: var(--text-2);
            cursor: pointer;
            transition: color 0.2s;
        }
        .filter-check:hover label { color: var(--text-1); }
        .filter-check input:checked + label { color: var(--text-1); font-weight: 600; }

        .filter-divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        .filter-apply-btn {
            width: 100%;
            padding: 10px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .filter-apply-btn:hover { background: var(--accent-hover); }

        /* ── Content Area ── */
        .tpl-content {
            flex: 1;
            padding: 28px 32px;
            min-width: 0;
        }

        /* Toolbar */
        .tpl-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .tpl-result-count {
            font-size: 13px;
            color: var(--text-2);
        }
        .tpl-result-count strong { color: var(--text-1); }
        .tpl-sort select {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            color: var(--text-1);
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            cursor: pointer;
        }
        .tpl-sort select option { background: #1a1a1a; color: #fff; }

        /* ── Template Grid ── */
        .tpl-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (max-width: 1400px) {
            .tpl-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 1100px) {
            .tpl-grid { grid-template-columns: repeat(2, 1fr); }
        }

        /* ── Template Card ── */
        .tpl-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .tpl-card:hover {
            border-color: rgba(194,46,245,0.3);
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .tpl-card-link { display: block; text-decoration: none; color: inherit; }
        .tpl-card-img {
            width: 100%;
            height: 220px;
            overflow: hidden;
            position: relative;
            background: #0d0d0d;
        }
        .tpl-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        .tpl-card:hover .tpl-card-img img { transform: scale(1.06); }

        /* Category badge on image */
        .tpl-card-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .tpl-card-body {
            padding: 16px 18px;
            border-top: 1px solid var(--border);
        }
        .tpl-card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-1);
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .tpl-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tpl-card-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--accent);
        }
        .tpl-card-preview {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-2);
            padding: 5px 14px;
            border: 1px solid var(--border);
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }
        .tpl-card:hover .tpl-card-preview {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* Tools tags */
        .tpl-card-tools {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 10px;
        }
        .tpl-card-tools span {
            font-size: 10px;
            color: var(--text-3);
            background: rgba(255,255,255,0.04);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* ── Empty State ── */
        .tpl-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
        }
        .tpl-empty svg { color: var(--text-3); margin-bottom: 16px; }
        .tpl-empty h3 { color: var(--text-1); font-size: 20px; margin-bottom: 8px; }
        .tpl-empty p { color: var(--text-2); font-size: 14px; }

        /* ── Pagination ── */
        .tpl-pagination {
            display: flex;
            justify-content: center;
            padding: 40px 0 0;
        }
        .tpl-pagination .pagination { gap: 4px; }
        .tpl-pagination .page-link {
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-2);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
        }
        .tpl-pagination .page-link:hover,
        .tpl-pagination .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* ── Responsive ── */
        @media (max-width: 992px) {
            .tpl-sidebar {
                display: none;
                position: fixed;
                top: 0; left: 0;
                width: 280px;
                height: 100vh;
                z-index: 1000;
                padding-top: 20px;
            }
            .tpl-sidebar.show { display: block; }
            .sidebar-toggle-btn { display: flex; }
            .tpl-content { padding: 20px 16px; }
        }

        @media (max-width: 768px) {
            .tpl-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .tpl-card-img { height: 160px; }
            .tpl-toolbar { flex-direction: column; gap: 12px; align-items: flex-start; }
        }
        @media (max-width: 480px) {
            .tpl-grid { grid-template-columns: 1fr; }
        }
    </style>
@endsection

@section('content')
@include('_partials.frontend.header')
<main>
    <div id="ajax-catalog-container">
    {{-- ── Hero ── --}}
    <section class="tpl-hero">
        <div class="container">
            <div class="breadcrumb-nav">
                <a href="{{ route('frontend.home') }}">Home</a> &rsaquo;
                <a href="{{ route('frontend.templates') }}">All Templates</a>
                @if(isset($activeTypeTitle) && $activeTypeTitle)
                    &rsaquo; <span>{{ $activeTypeTitle }}</span>
                @endif
                @if(request('category'))
                    &rsaquo; <span>{{ ucfirst(str_replace('-', ' ', request('category'))) }}</span>
                @endif
            </div>
            <h1>{{ isset($activeTypeTitle) && $activeTypeTitle ? $activeTypeTitle : 'Professional' }} <span>Templates</span></h1>
            <p>Browse our curated collection of premium {{ isset($activeTypeTitle) && $activeTypeTitle ? strtolower($activeTypeTitle) : 'design' }} templates. Perfect for crafting a unique identity with style and professionalism.</p>
        </div>
    </section>

    {{-- ── Types Ribbon ── --}}
    <div class="tpl-types-ribbon">
        <div class="container">
            <a href="{{ route('frontend.templates') }}" class="tpl-type-pill {{ !isset($type) || !$type ? 'active' : '' }}">All Types</a>
            @if(isset($availableTypes))
                @foreach($availableTypes as $slug => $name)
                    <a href="{{ route('frontend.templates.type', ['type' => $slug]) }}" class="tpl-type-pill {{ isset($type) && $type === $slug ? 'active' : '' }}">{{ $name }}</a>
                @endforeach
            @endif
        </div>
    </div>

    @php
        $currentRoute = isset($type) && $type ? route('frontend.templates.type', ['type' => $type]) : route('frontend.templates');
    @endphp

    {{-- ── Search Bar ── --}}
    <section class="tpl-search-bar">
        <div class="container">
            <form class="tpl-search-inner" method="GET" action="{{ $currentRoute }}">
                {{-- Preserve existing filters --}}
                @if(request('category'))
                    @foreach((array)request('category') as $c)
                        <input type="hidden" name="category[]" value="{{ $c }}">
                    @endforeach
                @endif
                @if(request('tool'))
                    @foreach((array)request('tool') as $t)
                        <input type="hidden" name="tool[]" value="{{ $t }}">
                    @endforeach
                @endif
                <input type="text" name="search" class="tpl-search-input" placeholder="Search templates..." value="{{ request('search') }}">
                <button type="submit" class="tpl-search-btn">Search</button>
            </form>
        </div>
    </section>

    {{-- ── Layout: Sidebar + Grid ── --}}
    <div class="tpl-layout">

        {{-- ── Sidebar ── --}}
        <aside class="tpl-sidebar" id="filterSidebar">
            <form method="GET" action="{{ $currentRoute }}" id="filterForm">
                {{-- Preserve search --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Categories --}}
                <div class="filter-section">
                    <div class="filter-title">
                        Categories
                        @if(request('category'))
                            <a href="{{ $currentRoute . '?' . http_build_query(request()->except('category')) }}" class="filter-clear">&times; Clear</a>
                        @endif
                    </div>
                    @foreach($categories as $cat)
                    <div class="filter-check">
                        <input type="checkbox" name="category[]" value="{{ $cat->slug }}"
                               id="cat_{{ $cat->slug }}"
                               {{ in_array($cat->slug, (array)request('category')) ? 'checked' : '' }}>
                        <label for="cat_{{ $cat->slug }}">{{ $cat->name }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="filter-divider"></div>

                {{-- Compatible Tools --}}
                <div class="filter-section">
                    <div class="filter-title">Applications Supported</div>
                    @foreach($compatibleTools as $tool)
                    <div class="filter-check">
                        <input type="checkbox" name="tool[]" value="{{ $tool }}"
                               id="tool_{{ \Illuminate\Support\Str::slug($tool) }}"
                               {{ in_array($tool, (array)request('tool')) ? 'checked' : '' }}>
                        <label for="tool_{{ \Illuminate\Support\Str::slug($tool) }}">{{ $tool }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="filter-divider"></div>

                {{-- Color Space --}}
                <div class="filter-section">
                    <div class="filter-title">Color Space</div>
                    <div class="filter-check">
                        <input type="checkbox" id="cs_rgb" name="color_space[]" value="RGB" {{ in_array('RGB', (array)request('color_space')) ? 'checked' : '' }}>
                        <label for="cs_rgb">RGB</label>
                    </div>
                    <div class="filter-check">
                        <input type="checkbox" id="cs_cmyk" name="color_space[]" value="CMYK" {{ in_array('CMYK', (array)request('color_space')) ? 'checked' : '' }}>
                        <label for="cs_cmyk">CMYK</label>
                    </div>
                </div>

                <div class="filter-divider"></div>

                {{-- Orientation --}}
                <div class="filter-section">
                    <div class="filter-title">Orientation</div>
                    <div class="filter-check">
                        <input type="checkbox" id="ori_landscape" name="orientation[]" value="Landscape" {{ in_array('Landscape', (array)request('orientation')) ? 'checked' : '' }}>
                        <label for="ori_landscape">Landscape</label>
                    </div>
                    <div class="filter-check">
                        <input type="checkbox" id="ori_portrait" name="orientation[]" value="Portrait" {{ in_array('Portrait', (array)request('orientation')) ? 'checked' : '' }}>
                        <label for="ori_portrait">Portrait</label>
                    </div>
                    <div class="filter-check">
                        <input type="checkbox" id="ori_square" name="orientation[]" value="Square" {{ in_array('Square', (array)request('orientation')) ? 'checked' : '' }}>
                        <label for="ori_square">Square</label>
                    </div>
                </div>

                <div class="filter-divider"></div>

                {{-- Properties --}}
                <div class="filter-section">
                    <div class="filter-title">Properties</div>
                    @php $propsList = ['Vector', 'Layered', 'Editable', 'Print Ready']; @endphp
                    @foreach($propsList as $prop)
                    <div class="filter-check">
                        <input type="checkbox" id="prop_{{ \Illuminate\Support\Str::slug($prop) }}" name="property[]" value="{{ $prop }}" {{ in_array($prop, (array)request('property')) ? 'checked' : '' }}>
                        <label for="prop_{{ \Illuminate\Support\Str::slug($prop) }}">{{ $prop }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="filter-divider"></div>


            </form>
        </aside>

        {{-- ── Content Area ── --}}
        <div class="tpl-content">

            {{-- Mobile toggle --}}
            <button class="sidebar-toggle-btn" onclick="document.getElementById('filterSidebar').classList.toggle('show')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/></svg>
                Filters
            </button>

            {{-- Toolbar --}}
            <div class="tpl-toolbar">
                <span class="tpl-result-count">
                    Showing <strong>{{ $templates->count() }}</strong> of <strong>{{ $templates->total() }}</strong> templates
                </span>
                <div class="tpl-sort">
                    <form method="GET" action="{{ route('frontend.templates') }}" id="sortForm">
                        @foreach(request()->except('sort', 'page') as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        <select name="sort" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Sort by: Newest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Sort by: Popular</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Grid --}}
            <div class="tpl-grid">
                @forelse($templates as $template)
                <div class="tpl-card">
                    <a href="{{ route('frontend.single-template', $template->slug) }}" class="tpl-card-link">
                        <div class="tpl-card-img">
                            @if($template->main_thumbnail)
                                <img src="{{ asset('storage/' . $template->main_thumbnail) }}" alt="{{ $template->title }}">
                            @else
                                @php
                                    $placeholders = [
                                        'https://images.unsplash.com/photo-1611162617474-5b21e879e113?auto=format&fit=crop&w=600&q=80',
                                        'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=600&q=80',
                                        'https://images.unsplash.com/photo-1620641788421-7a1c342ea42e?auto=format&fit=crop&w=600&q=80',
                                        'https://images.unsplash.com/photo-1541462608143-67571c6738dd?auto=format&fit=crop&w=600&q=80',
                                        'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=600&q=80',
                                        'https://images.unsplash.com/photo-1633356122544-f134324a6cee?auto=format&fit=crop&w=600&q=80'
                                    ];
                                @endphp
                                <img src="{{ $placeholders[$template->id % count($placeholders)] }}" alt="{{ $template->title }}">
                            @endif
                            @if($template->category)
                                <span class="tpl-card-badge">{{ $template->category->name }}</span>
                            @endif
                        </div>
                    </a>
                    <div class="tpl-card-body">
                        {{-- Compatible Tools Tags --}}
                        @if(!empty($template->meta_data['compatible_tools']))
                        <div class="tpl-card-tools">
                            @foreach(array_slice($template->meta_data['compatible_tools'], 0, 3) as $tool)
                                <span>{{ $tool }}</span>
                            @endforeach
                            @if(count($template->meta_data['compatible_tools']) > 3)
                                <span>+{{ count($template->meta_data['compatible_tools']) - 3 }}</span>
                            @endif
                        </div>
                        @endif

                        <div class="tpl-card-title">{{ $template->title }}</div>
                        <div class="tpl-card-footer">
                            <span class="tpl-card-price">${{ number_format($template->price, 2) }}</span>
                            <a href="{{ route('frontend.single-template', $template->slug) }}" class="tpl-card-preview">Preview</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="tpl-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <h3>No templates found</h3>
                    <p>Try adjusting your filters or search criteria.</p>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($templates->hasPages())
            <div class="tpl-pagination">
                {{ $templates->links() }}
            </div>
            @endif
        </div>
    </div>
    </div>
</main>
@include('_partials.frontend.footer')
@endsection

@section('page-script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    // Card entrance animation
    gsap.from('.tpl-card', {
        y: 30, opacity: 0, duration: 0.5, stagger: 0.06, ease: 'power2.out', delay: 0.15
    });

    // Close mobile sidebar on outside click
    $(document).on('click', function(e) {
        const $sidebar = $('#filterSidebar');
        const $toggle = $('.sidebar-toggle-btn');
        if ($sidebar.hasClass('show') && !$sidebar.is(e.target) && $sidebar.has(e.target).length === 0 && !$toggle.is(e.target) && $toggle.has(e.target).length === 0) {
            $sidebar.removeClass('show');
        }
    });

    // ── AJAX Filtering (jQuery) ──
    const loadContent = (url) => {
        const $container = $('#ajax-catalog-container');
        if (!$container.length) return;

        // Update browser URL
        window.history.pushState({}, '', url);

        // Add loading state
        $container.css('opacity', '0.5');

        $.ajax({
            url: url,
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                // Parse out the container from response
                const newHtml = $(response).find('#ajax-catalog-container').html();
                
                if (newHtml) {
                    $container.html(newHtml);
                    
                    // Re-trigger GSAP animations
                    gsap.from('.tpl-card', {
                        y: 30, opacity: 0, duration: 0.5, stagger: 0.06, ease: 'power2.out'
                    });
                }
                $container.css('opacity', '1');
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                $container.css('opacity', '1');
            }
        });
    };

    // Handle Link Clicks (Pagination, Categories inside the container)
    $(document).on('click', 'a', function(e) {
        const $link = $(this);
        if ($link.closest('#ajax-catalog-container').length && !$link.hasClass('tpl-card-preview') && !$link.hasClass('tpl-card-link')) {
            const href = $link.attr('href');
            if (href && href.includes('/design-templates')) {
                e.preventDefault();
                loadContent(href);
            }
        }
    });

    // Handle Form Submissions (Search bar, etc.)
    $(document).on('submit', '#filterForm, .tpl-search-inner', function(e) {
        if ($(this).attr('method').toUpperCase() === 'GET') {
            e.preventDefault();
            const actionUrl = $(this).attr('action') || window.location.pathname;
            const queryString = $(this).serialize(); // Serialize is bulletproof for arrays
            const separator = actionUrl.includes('?') ? '&' : '?';
            loadContent(actionUrl + separator + queryString);
        }
    });

    // Handle Checkbox/Select Changes (Auto-submit)
    $(document).on('change', '#filterForm input, #filterForm select', function(e) {
        const $form = $(this).closest('form');
        if ($form.length) {
            const actionUrl = $form.attr('action') || window.location.pathname;
            const queryString = $form.serialize();
            const separator = actionUrl.includes('?') ? '&' : '?';
            loadContent(actionUrl + separator + queryString);
        }
    });

    // Handle Browser Back/Forward
    $(window).on('popstate', function() {
        loadContent(window.location.href);
    });
</script>
@endsection
