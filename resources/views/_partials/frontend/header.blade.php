<!-- Header -->
<header class="app-header">
    <div class="header-container">
        <div class="header-logo" onclick="window.location.href='{{ route('frontend.home') }}'">
            CANVATO.
        </div>
        
        <nav class="header-nav">
            <a href="{{ route('frontend.home') }}" class="{{ request()->routeIs('frontend.home') ? 'text-accent' : '' }}">Home</a>
            
            {{-- Design Templates Mega Menu --}}
            <div class="mega-menu-trigger">
                <a href="{{ route('frontend.templates') }}" class="{{ request()->routeIs('frontend.templates') ? 'text-accent' : '' }}">
                    Design Templates
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-left:4px;vertical-align:middle;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </a>
                <div class="mega-menu">
                    <div class="mega-col">
                        <h4>All Types</h4>
                        <a href="{{ route('frontend.templates.type', ['type' => 'logos']) }}">Logos</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'websites']) }}">Websites</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'social-media']) }}">Social Media</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'product-mockups']) }}">Product Mockups</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'ux-ui-toolkits']) }}">UX/UI Kits</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'infographics']) }}">Infographics</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'scene-generators']) }}">Scene Generators</a>
                        <a href="{{ route('frontend.templates.type', ['type' => 'printable-templates']) }}">Print Templates</a>
                    </div>
                    <div class="mega-col">
                        <h4>Compatible Tools</h4>
                        <a href="{{ route('frontend.templates', ['tool' => ['Adobe Photoshop']]) }}">Adobe Photoshop</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['Adobe Illustrator']]) }}">Adobe Illustrator</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['Adobe InDesign']]) }}">Adobe InDesign</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['Figma']]) }}">Figma</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['Canva']]) }}">Canva</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['PowerPoint']]) }}">PowerPoint</a>
                        <a href="{{ route('frontend.templates', ['tool' => ['Keynote']]) }}">Keynote</a>
                    </div>
                    <div class="mega-col">
                        <h4>Popular Searches</h4>
                        <a href="{{ route('frontend.templates', ['search' => 'Business Card']) }}">Business Card</a>
                        <a href="{{ route('frontend.templates', ['search' => 'Brochure']) }}">Brochure</a>
                        <a href="{{ route('frontend.templates', ['search' => 'Flyer']) }}">Flyer</a>
                        <a href="{{ route('frontend.templates', ['search' => 'Resume']) }}">Resume</a>
                        <a href="{{ route('frontend.templates', ['search' => 'Wedding']) }}">Wedding</a>
                        <a href="{{ route('frontend.templates', ['search' => 'Logo']) }}">Logo</a>
                    </div>
                </div>
            </div>

            <a href="#">Resources</a>
            <a href="#">Community</a>
            <a href="#">Pricing</a>
        </nav>

        <div class="header-actions">
            <div class="search-bar">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Search assets...">
                <div class="search-shortcut">⌘K</div>
            </div>
            
            <!-- User Dropdown -->
            <div class="user-dropdown-container">
                <button class="icon-btn" aria-label="Account" id="userDropdownBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </button>
                <div class="user-dropdown-menu" id="userDropdownMenu">
                    @auth
                        <div class="dropdown-header">
                            <span class="dropdown-name">{{ auth()->user()->name }}</span>
                            <span class="dropdown-email">{{ auth()->user()->email }}</span>
                        </div>
                        <a href="{{ route('frontend.profile') }}" class="dropdown-item">Profile Settings</a>
                        <a href="{{ route('frontend.orders') }}" class="dropdown-item">Order History</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; font-family: inherit;">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                        <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                    @endauth
                </div>
            </div>
        </div>

<style>
/* User Dropdown Styles */
.user-dropdown-container {
    position: relative;
    display: inline-block;
}

.user-dropdown-menu {
    position: absolute;
    top: 120%;
    right: 0;
    width: 220px;
    background: #141414;
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 8px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.6);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    z-index: 1000;
}

.user-dropdown-container:hover .user-dropdown-menu,
.user-dropdown-container:focus-within .user-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    padding: 12px 16px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    margin-bottom: 8px;
}

.dropdown-name {
    display: block;
    font-size: 0.9rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 4px;
}

.dropdown-email {
    display: block;
    font-size: 0.75rem;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dropdown-item {
    display: block;
    padding: 10px 16px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
}

.dropdown-item.text-danger {
    color: #ff4444;
}

.dropdown-item.text-danger:hover {
    background: rgba(255, 68, 68, 0.1);
}

.dropdown-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.05);
    margin: 8px 0;
}
</style>
    </div>
</header>
