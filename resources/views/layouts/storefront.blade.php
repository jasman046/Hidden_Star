<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hidden Star') — Streetwear Brand</title>
    <meta name="description" content="@yield('meta-description', 'Hidden Star — Premium streetwear brand. Shop the latest collection.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        teal: { DEFAULT: '#007F7F', light: '#e0f2f2', dark: '#005f5f' },
                    }
                }
            }
        }
    </script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: #000; margin: 0; }

        /* ── Navbar ── */
        .nav-link { font-size: .8rem; font-weight: 500; letter-spacing: .08em; text-transform: uppercase; color: #000; text-decoration: none; padding: .25rem 0; border-bottom: 1px solid transparent; transition: border-color .2s; }
        .nav-link:hover, .nav-link.active { border-bottom-color: #000; }

        /* ── Hero Banner ── */
        .hero { position: relative; width: 100%; background: #111; overflow: hidden; }
        .hero-img { width: 100%; height: 100vh; object-fit: cover; display: block; }
        .hero-btn { position: absolute; bottom: 2rem; left: 2rem; display: inline-flex; align-items: center; gap: .5rem; padding: .6rem 1.25rem; background: #fff; color: #000; font-size: .75rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; text-decoration: none; border: none; cursor: pointer; transition: background .2s, color .2s; }
        .hero-btn:hover { background: #000; color: #fff; }

        /* ── Product Card ── */
        .product-card { position: relative; background: #fff; min-width: 0; box-sizing: border-box; overflow: hidden; }
        .product-card-img-wrap { position: relative; overflow: hidden; background: #f5f5f5; aspect-ratio: 3/4; }
        .product-card-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s ease; }
        .product-card:hover .product-card-img-wrap img { transform: scale(1.04); }
        .product-card-add { position: absolute; bottom: .75rem; right: .75rem; width: 2.25rem; height: 2.25rem; background: #007F7F; color: #fff; border: none; cursor: pointer; font-size: 1.4rem; font-weight: 300; display: flex; align-items: center; justify-content: center; opacity: 0; transform: translateY(6px); transition: opacity .25s, transform .25s; line-height: 1; }
        .product-card:hover .product-card-add { opacity: 1; transform: translateY(0); }
        .product-card-info { padding: .75rem 0 1rem; }
        .product-card-category { font-size: .68rem; font-weight: 500; color: #888; text-transform: uppercase; letter-spacing: .07em; margin-bottom: .2rem; }
        .product-card-name { font-size: .9rem; font-weight: 600; color: #000; margin-bottom: .25rem; line-height: 1.3; }
        .product-card-price { font-size: .875rem; font-weight: 700; color: #007F7F; }

        /* ── Masonry grid ── */
        .masonry { columns: 4; column-gap: 1.25rem; }
        .masonry-item { break-inside: avoid; margin-bottom: 1.25rem; }
        @media (max-width: 1024px) { .masonry { columns: 3; } }
        @media (max-width: 640px) { .masonry { columns: 2; column-gap: .75rem; } .masonry-item { margin-bottom: .75rem; } }

        /* ── Product grids (home + shop) — responsive breakpoints ── */
        .product-grid-home,
        .shop-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        @media (max-width: 1024px) {
            .product-grid-home, .shop-grid { grid-template-columns: repeat(3, 1fr) !important; }
        }
        @media (max-width: 640px) {
            .product-grid-home, .shop-grid { grid-template-columns: repeat(2, 1fr) !important; gap: .75rem !important; }
        }

        /* ── Gallery masonry ── */
        .gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; }
        .gallery-grid .tall { grid-row: span 2; }
        .gallery-grid img { width: 100%; height: 100%; object-fit: cover; display: block; }
        @media (max-width: 768px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }

        /* ── Mobile nav drawer ── */
        .mobile-drawer { position: fixed; top: 0; left: 0; height: 100%; width: 75vw; max-width: 300px; background: #fff; z-index: 100; transform: translateX(-100%); transition: transform .3s ease; padding: 2rem 1.5rem; display: flex; flex-direction: column; gap: 1.5rem; }
        .mobile-drawer.open { transform: translateX(0); }
        .drawer-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 99; }
        .drawer-overlay.active { display: block; }

        /* ── Section headings ── */
        .section-tag { font-size: .7rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: #888; margin-bottom: .5rem; }
        .section-title { font-size: 1.5rem; font-weight: 800; color: #000; letter-spacing: -.01em; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Mobile Drawer Overlay --}}
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>

{{-- Mobile Nav Drawer --}}
<div class="mobile-drawer" id="mobileDrawer">
    <button onclick="closeDrawer()" style="align-self:flex-end;background:none;border:none;font-size:1.5rem;cursor:pointer;padding:0;">✕</button>
    <a href="{{ route('home') }}" class="nav-link text-lg {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('shop') }}" class="nav-link text-lg {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
    <a href="{{ route('about') }}" class="nav-link text-lg {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
    <hr style="border:none;border-top:1px solid #eee;">
    <a href="{{ route('admin.dashboard') }}" class="nav-link text-sm" style="color:#888;">Admin Panel →</a>
</div>

{{-- ═══ HEADER ═══ --}}
<header style="position:sticky;top:0;z-index:50;background:#fff;border-bottom:1px solid #000;">
    <div style="max-width:1400px;margin:0 auto;padding:0 1.5rem;display:flex;align-items:center;justify-content:space-between;height:60px;">

        {{-- Mobile: Hamburger --}}
        <button class="md:hidden" onclick="openDrawer()" style="background:none;border:none;cursor:pointer;padding:.25rem;" aria-label="Menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>

        {{-- Logo / Brand --}}
        <a href="{{ route('home') }}" style="text-decoration:none;display:flex;flex-direction:column;align-items:center;">
            {{-- Red oval logo mark --}}
            <svg width="80" height="32" viewBox="0 0 120 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="60" cy="22" rx="58" ry="20" stroke="#CC0000" stroke-width="3" fill="none"/>
                <text x="60" y="27" text-anchor="middle" font-family="Inter,sans-serif" font-size="13" font-weight="900" fill="#CC0000" letter-spacing="2">★HIDDS★</text>
            </svg>
        </a>

        {{-- Desktop Nav (centered) --}}
        <nav class="hidden md:flex items-center gap-8 absolute left-1/2 -translate-x-1/2">
            <a href="{{ route('home') }}"  class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('shop') }}"  class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}">Shop</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
        </nav>

        {{-- Right Icons --}}
        <div style="display:flex;align-items:center;gap:1rem;">
            {{-- Search --}}
            <button onclick="toggleSearch()" style="background:none;border:none;cursor:pointer;padding:.25rem;" aria-label="Search" class="hidden md:block">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </button>
            {{-- Cart --}}
            <a href="{{ route('shop') }}" style="color:#000;position:relative;" aria-label="Cart">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </a>
            {{-- Profile --}}
            <button style="background:none;border:none;cursor:pointer;padding:.25rem;" aria-label="Account">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </button>
        </div>
    </div>

    {{-- Search Bar (hidden by default) --}}
    <div id="searchBar" style="display:none;border-top:1px solid #eee;padding:.75rem 1.5rem;max-width:1400px;margin:0 auto;">
        <form action="{{ route('shop') }}" method="GET" style="display:flex;align-items:center;gap:.75rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input name="search" type="text" placeholder="Search products…" value="{{ request('search') }}" autofocus style="flex:1;border:none;outline:none;font-size:.9rem;font-family:Inter,sans-serif;">
            <button type="button" onclick="toggleSearch()" style="background:none;border:none;cursor:pointer;font-size:1.2rem;color:#888;">✕</button>
        </form>
    </div>
</header>

{{-- Page Content --}}
@yield('content')

{{-- ═══ FOOTER ═══ --}}
<footer style="border-top:1px solid #000;margin-top:5rem;padding:3rem 1.5rem 2rem;background:#fff;">
    <div style="max-width:1400px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;">
        <div>
            <div style="font-weight:800;letter-spacing:.1em;text-transform:uppercase;margin-bottom:1rem;">Hidden Star</div>
            <p style="font-size:.825rem;color:#555;line-height:1.7;max-width:220px;">At elegant vogue, we blend creativity with craftsmanship to create fashion that transcends trends.</p>
        </div>
        <div>
            <div style="font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:.875rem;color:#888;">Links</div>
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <a href="{{ route('home') }}"  style="font-size:.825rem;color:#000;text-decoration:none;">Home</a>
                <a href="{{ route('shop') }}"  style="font-size:.825rem;color:#000;text-decoration:none;">Shop</a>
                <a href="{{ route('about') }}" style="font-size:.825rem;color:#000;text-decoration:none;">About Us</a>
                <a href="{{ route('admin.dashboard') }}" style="font-size:.825rem;color:#888;text-decoration:none;">Admin</a>
            </div>
        </div>
        <div>
            <div style="font-size:.7rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;margin-bottom:.875rem;color:#888;">Contact</div>
            <p style="font-size:.825rem;color:#555;line-height:1.7;">Instagram: @hiddenstar<br>Email: hello@hiddenstar.id</p>
        </div>
    </div>
    <div style="max-width:1400px;margin:2rem auto 0;padding-top:1.5rem;border-top:1px solid #eee;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div style="display:flex;justify-content:center;width:100%;">
            <svg width="100" height="38" viewBox="0 0 120 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="60" cy="22" rx="58" ry="20" stroke="#CC0000" stroke-width="2.5" fill="none"/>
                <text x="60" y="27" text-anchor="middle" font-family="Inter,sans-serif" font-size="12" font-weight="900" fill="#CC0000" letter-spacing="2">★HIDDS★</text>
            </svg>
        </div>
        <p style="font-size:.75rem;color:#aaa;text-align:center;width:100%;">© {{ date('Y') }} Hidden Star. All rights reserved.</p>
    </div>
</footer>

<script>
    function openDrawer()  { document.getElementById('mobileDrawer').classList.add('open'); document.getElementById('drawerOverlay').classList.add('active'); }
    function closeDrawer() { document.getElementById('mobileDrawer').classList.remove('open'); document.getElementById('drawerOverlay').classList.remove('active'); }
    function toggleSearch() { const sb = document.getElementById('searchBar'); sb.style.display = sb.style.display === 'none' ? 'block' : 'none'; if (sb.style.display === 'block') sb.querySelector('input').focus(); }
</script>
@stack('scripts')
</body>
</html>
