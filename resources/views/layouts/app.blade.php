<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Hidden Star Admin</title>
    <meta name="description" content="Hidden Star streetwear brand administration panel.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite (with CDN fallback) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- CDN fallback when Vite build is not available --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            /* ========================================================
               Hidden Star Admin – Embedded Stylesheet
               (Used when Vite build is not compiled)
            ======================================================== */
            body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; color: #1e293b; margin:0; }
            *, *::before, *::after { box-sizing: border-box; }

            /* ---------- Sidebar ---------- */
            .sidebar { width:260px; min-height:100vh; background:#1e293b; position:fixed; top:0; left:0; z-index:50; display:flex; flex-direction:column; transition:transform .3s ease; }
            .sidebar-logo { padding:1.5rem 1.25rem; border-bottom:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.75rem; }
            .sidebar-brand { font-size:1.05rem; font-weight:800; color:#fff; letter-spacing:.08em; text-transform:uppercase; line-height:1.2; }
            .sidebar-brand span { display:block; font-size:.65rem; font-weight:400; color:#94a3b8; letter-spacing:.15em; text-transform:uppercase; }
            .sidebar-nav { flex:1; padding:1.25rem 0; overflow-y:auto; }
            .sidebar-section-label { font-size:.65rem; font-weight:600; color:#64748b; letter-spacing:.12em; text-transform:uppercase; padding:.5rem 1.25rem .25rem; margin-top:.75rem; }
            .sidebar-nav-item { display:flex; align-items:center; gap:.75rem; padding:.65rem 1.25rem; color:#94a3b8; font-size:.875rem; font-weight:500; text-decoration:none; transition:all .2s; border-left:3px solid transparent; cursor:pointer; }
            .sidebar-nav-item:hover { color:#e2e8f0; background:rgba(255,255,255,.05); }
            .sidebar-nav-item.active { color:#2dd4bf; background:rgba(13,148,136,.12); border-left-color:#0d9488; }
            .sidebar-nav-item svg { width:1.125rem; height:1.125rem; flex-shrink:0; }
            .sidebar-footer { padding:1rem 1.25rem; border-top:1px solid rgba(255,255,255,.08); display:flex; align-items:center; gap:.75rem; }
            .sidebar-footer-avatar { width:2rem; height:2rem; border-radius:50%; background:linear-gradient(135deg,#0d9488,#0f766e); display:flex; align-items:center; justify-content:center; font-size:.75rem; font-weight:700; color:#fff; flex-shrink:0; }
            .sidebar-footer-info { flex:1; min-width:0; }
            .sidebar-footer-name { font-size:.8rem; font-weight:600; color:#e2e8f0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
            .sidebar-footer-role { font-size:.7rem; color:#64748b; }

            /* ---------- Main ---------- */
            .main-content { margin-left:260px; min-height:100vh; display:flex; flex-direction:column; }
            .topbar { background:#fff; border-bottom:1px solid #e2e8f0; padding:.875rem 1.5rem; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:40; }
            .topbar-title { font-size:1rem; font-weight:600; color:#1e293b; }
            .topbar-subtitle { font-size:.75rem; color:#94a3b8; margin-top:.125rem; }
            .topbar-actions { display:flex; align-items:center; gap:.75rem; }
            .burger-btn { display:none; align-items:center; justify-content:center; width:2.25rem; height:2.25rem; border-radius:.5rem; background:#f1f5f9; border:none; cursor:pointer; color:#64748b; }
            .page-content { padding:1.5rem; flex:1; }

            /* ---------- Welcome Card ---------- */
            .welcome-card { background:linear-gradient(135deg,#0d9488 0%,#0f766e 60%,#134e4a 100%); border-radius:.875rem; padding:1.75rem; color:#fff; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; position:relative; overflow:hidden; }
            .welcome-card::before { content:''; position:absolute; top:-40px; right:-40px; width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.06); }
            .welcome-card::after { content:''; position:absolute; bottom:-60px; right:60px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,.04); }
            .welcome-card-title { font-size:1.4rem; font-weight:700; letter-spacing:-.01em; margin-bottom:.375rem; }
            .welcome-card-subtitle { font-size:.85rem; opacity:.75; max-width:400px; }
            .welcome-card-logo { position:relative; z-index:1; opacity:.3; flex-shrink:0; }

            /* ---------- Stats Grid ---------- */
            .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem; }
            .stat-card { background:#fff; border-radius:.75rem; padding:1.25rem; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); position:relative; overflow:hidden; transition:transform .2s,box-shadow .2s; }
            .stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 16px rgba(0,0,0,.08); }
            .stat-card-icon { width:2.5rem; height:2.5rem; border-radius:.625rem; display:flex; align-items:center; justify-content:center; margin-bottom:.875rem; }
            .stat-card-icon svg { width:1.25rem; height:1.25rem; }
            .stat-card-label { font-size:.725rem; font-weight:500; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-bottom:.25rem; }
            .stat-card-value { font-size:1.625rem; font-weight:700; color:#1e293b; line-height:1; margin-bottom:.25rem; }
            .stat-card-sub { font-size:.725rem; color:#94a3b8; }

            /* ---------- Panels ---------- */
            .panel { background:#fff; border-radius:.875rem; border:1px solid #f1f5f9; box-shadow:0 1px 3px rgba(0,0,0,.04); overflow:hidden; }
            .panel-header { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
            .panel-title { font-size:.875rem; font-weight:600; color:#1e293b; }
            .panel-action { font-size:.75rem; color:#0d9488; font-weight:500; text-decoration:none; transition:color .2s; }
            .panel-action:hover { color:#0f766e; }

            /* ---------- Tables ---------- */
            .data-table { width:100%; border-collapse:collapse; font-size:.8125rem; }
            .data-table thead th { background:#f8fafc; padding:.75rem 1rem; text-align:left; font-size:.7rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.07em; border-bottom:1px solid #f1f5f9; white-space:nowrap; }
            .data-table tbody td { padding:.75rem 1rem; border-bottom:1px solid #f8fafc; color:#334155; vertical-align:middle; }
            .data-table tbody tr:last-child td { border-bottom:none; }
            .data-table tbody tr:hover td { background:#fafbfc; }
            .data-table .product-name { font-weight:600; color:#0d9488; }
            .data-table .product-price { font-weight:600; color:#0d9488; }

            /* ---------- Badges ---------- */
            .badge { display:inline-flex; align-items:center; padding:.25rem .625rem; border-radius:999px; font-size:.7rem; font-weight:600; letter-spacing:.03em; white-space:nowrap; }
            .badge-completed { background:#d1fae5; color:#065f46; }
            .badge-pending { background:#fef3c7; color:#92400e; }
            .badge-processing { background:#ede9fe; color:#5b21b6; }
            .badge-cancelled { background:#fee2e2; color:#991b1b; }
            .badge-active { background:#d1fae5; color:#065f46; }
            .cat-badge { display:inline-flex; align-items:center; padding:.2rem .5rem; border-radius:.375rem; font-size:.68rem; font-weight:500; }
            .cat-tshirts { background:#ede9fe; color:#5b21b6; }
            .cat-footwear { background:#fce7f3; color:#9d174d; }
            .cat-headwear { background:#dbeafe; color:#1e40af; }
            .cat-hoodies  { background:#fef3c7; color:#92400e; }
            .cat-bottoms  { background:#dcfce7; color:#166534; }
            .cat-accessories { background:#ffedd5; color:#9a3412; }
            .cat-outerwear { background:#f0f9ff; color:#0c4a6e; }
            .cat-default  { background:#f1f5f9; color:#475569; }

            /* ---------- Activity List ---------- */
            .activity-list { list-style:none; padding:0; margin:0; }
            .activity-item { display:flex; align-items:center; gap:.875rem; padding:.75rem 1.25rem; border-bottom:1px solid #f8fafc; transition:background .15s; }
            .activity-item:last-child { border-bottom:none; }
            .activity-item:hover { background:#fafbfc; }
            .activity-avatar { width:2rem; height:2rem; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:.7rem; font-weight:700; color:#fff; flex-shrink:0; }
            .activity-info { flex:1; min-width:0; }
            .activity-name { font-size:.8rem; font-weight:600; color:#1e293b; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
            .activity-meta { font-size:.72rem; color:#94a3b8; margin-top:.1rem; }
            .activity-price { font-size:.8rem; font-weight:600; color:#0d9488; flex-shrink:0; }

            /* ---------- Filter Bar ---------- */
            .filter-bar { display:flex; align-items:center; gap:.75rem; padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; flex-wrap:wrap; }
            .filter-input { flex:1; min-width:180px; padding:.5rem .875rem; border:1px solid #e2e8f0; border-radius:.5rem; font-size:.8125rem; color:#334155; outline:none; transition:border-color .2s,box-shadow .2s; background:#fff; }
            .filter-input:focus { border-color:#0d9488; box-shadow:0 0 0 3px rgba(13,148,136,.08); }
            .filter-select { padding:.5rem .875rem; border:1px solid #e2e8f0; border-radius:.5rem; font-size:.8125rem; color:#334155; outline:none; background:#fff; cursor:pointer; transition:border-color .2s; }
            .filter-select:focus { border-color:#0d9488; }
            .filter-btn { padding:.5rem 1rem; background:#0d9488; color:#fff; border:none; border-radius:.5rem; font-size:.8125rem; font-weight:500; cursor:pointer; transition:background .2s; }
            .filter-btn:hover { background:#0f766e; }

            /* ---------- Pagination ---------- */
            .pagination-wrapper { padding:.875rem 1.25rem; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; }
            .pagination-info { font-size:.775rem; color:#94a3b8; }

            /* ---------- Grids ---------- */
            .dashboard-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem; }

            /* ---------- Overlay ---------- */
            .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:45; }

            /* ---------- Table wrapper ---------- */
            .table-wrapper { overflow-x:auto; }

            /* ---------- Scrollbar ---------- */
            ::-webkit-scrollbar { width:5px; height:5px; }
            ::-webkit-scrollbar-track { background:#f1f5f9; }
            ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:999px; }
            ::-webkit-scrollbar-thumb:hover { background:#94a3b8; }

            /* ---------- Responsive ---------- */
            @media (max-width:1200px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
            @media (max-width:1024px) { .dashboard-grid { grid-template-columns:1fr; } }
            @media (max-width:768px) {
                .sidebar { transform:translateX(-100%); }
                .sidebar.sidebar-open { transform:translateX(0); }
                .sidebar-overlay.active { display:block; }
                .main-content { margin-left:0; }
                .burger-btn { display:flex; }
                .stats-grid { grid-template-columns:repeat(2,1fr); }
                .page-content { padding:1rem; }
                .welcome-card-logo { display:none; }
            }
            @media (max-width:480px) {
                .stats-grid { grid-template-columns:1fr 1fr; gap:.75rem; }
                .stat-card-value { font-size:1.25rem; }
                .welcome-card-title { font-size:1.1rem; }
                .topbar { padding:.75rem 1rem; }
                .page-content { padding:.75rem; }
            }
        </style>
    @endif
</head>
<body>

{{-- Sidebar Overlay (Mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    {{-- Logo / Brand --}}
    <div class="sidebar-logo">
        {{-- Hidden Star Logo Mark (SVG inline) --}}
        <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="36" height="36" rx="8" fill="#0d9488"/>
            <ellipse cx="18" cy="18" rx="12" ry="8" stroke="#ffffff" stroke-width="1.5" fill="none"/>
            <text x="18" y="22" text-anchor="middle" font-family="Inter" font-size="7" font-weight="900" fill="#ffffff" letter-spacing="0.5">HIDDS</text>
            {{-- Star decorations --}}
            <circle cx="6" cy="18" r="1.5" fill="#2dd4bf"/>
            <circle cx="30" cy="18" r="1.5" fill="#2dd4bf"/>
            <polygon points="18,4 18.9,7 21.9,7 19.5,8.9 20.4,11.9 18,10 15.6,11.9 16.5,8.9 14.1,7 17.1,7" fill="#2dd4bf"/>
        </svg>
        <div>
            <div class="sidebar-brand">Hidden Star<span>Admin Panel</span></div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Main</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}" id="nav-dashboard">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
            </svg>
            Dashboard
        </a>

        <div class="sidebar-section-label">Catalog</div>

        <a href="{{ route('admin.products.index') }}"
           class="sidebar-nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" id="nav-products">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            Products
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="sidebar-nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" id="nav-orders">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 11 12 14 22 4"/>
                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
            </svg>
            Orders
        </a>

        <div class="sidebar-section-label">Analytics</div>

        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item" id="nav-analytics">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            Reports
        </a>

        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item" id="nav-customers">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
            </svg>
            Customers
        </a>

        <div class="sidebar-section-label">Appearance</div>

        <a href="{{ route('admin.content.index') }}"
           class="sidebar-nav-item {{ request()->routeIs('admin.content.*') ? 'active' : '' }}" id="nav-content">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
            </svg>
            Site Content
        </a>

        <div class="sidebar-section-label">Settings</div>

        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item" id="nav-settings">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
            </svg>
            Settings
        </a>
    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <div class="sidebar-footer-avatar">HS</div>
        <div class="sidebar-footer-info">
            <div class="sidebar-footer-name">Admin User</div>
            <div class="sidebar-footer-role">Super Administrator</div>
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
            <polyline points="16 17 21 12 16 7"/>
            <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
    </div>
</aside>

{{-- Main Content --}}
<div class="main-content" id="mainContent">

    {{-- Topbar --}}
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <button class="burger-btn" id="burgerBtn" onclick="toggleSidebar()" aria-label="Toggle Sidebar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <line x1="3" y1="12" x2="21" y2="12"/>
                    <line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-subtitle">@yield('page-subtitle', 'Hidden Star Admin Panel')</div>
            </div>
        </div>
        <div class="topbar-actions">
            {{-- Notification bell --}}
            <button style="width:2.25rem;height:2.25rem;border-radius:0.5rem;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;position:relative;" aria-label="Notifications">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
                <span style="position:absolute;top:4px;right:4px;width:7px;height:7px;background:#ef4444;border-radius:50%;border:1.5px solid white;"></span>
            </button>

            {{-- Avatar --}}
            <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:linear-gradient(135deg,#0d9488,#0f766e);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:white;cursor:pointer;">HS</div>
        </div>
    </header>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="margin:1rem 1.5rem 0;padding:0.75rem 1rem;background:#d1fae5;color:#065f46;border-radius:0.5rem;font-size:0.825rem;display:flex;align-items:center;gap:0.5rem;">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Page Content --}}
    <main class="page-content">
        @yield('content')
    </main>

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('sidebar-open');
        overlay.classList.toggle('active');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.remove('sidebar-open');
        overlay.classList.remove('active');
    }

    // Close sidebar on resize to desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
</script>
@stack('scripts')
</body>
</html>
