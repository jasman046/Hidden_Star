@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back — here\'s your overview')

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-card">
    <div>
        <div class="welcome-card-title">Welcome to the Hidden Star dashboard</div>
        <div class="welcome-card-subtitle">
            Manage your streetwear products, track orders, and monitor sales performance all in one place.
        </div>
        <div style="margin-top:1rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
            <a href="{{ route('admin.products.index') }}" style="display:inline-flex;align-items:center;gap:0.375rem;padding:0.5rem 1rem;background:rgba(255,255,255,0.18);color:white;border-radius:0.5rem;font-size:0.8rem;font-weight:500;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.18)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                View Products
            </a>
            <a href="{{ route('admin.orders.index') }}" style="display:inline-flex;align-items:center;gap:0.375rem;padding:0.5rem 1rem;background:rgba(255,255,255,0.10);color:rgba(255,255,255,0.85);border-radius:0.5rem;font-size:0.8rem;font-weight:500;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.18)'" onmouseout="this.style.background='rgba(255,255,255,0.10)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                View Orders
            </a>
        </div>
    </div>
    <div class="welcome-card-logo">
        <svg width="120" height="80" viewBox="0 0 120 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="60" cy="40" rx="45" ry="28" stroke="white" stroke-width="2" fill="none" opacity="0.6"/>
            <ellipse cx="60" cy="40" rx="35" ry="20" stroke="white" stroke-width="1.5" fill="none" opacity="0.4"/>
            <text x="60" y="46" text-anchor="middle" font-family="Inter" font-size="16" font-weight="900" fill="white" letter-spacing="2" opacity="0.8">HIDDS★</text>
            <circle cx="15" cy="40" r="3" fill="white" opacity="0.5"/>
            <circle cx="105" cy="40" r="3" fill="white" opacity="0.5"/>
            <polygon points="60,8 62,14 68,14 63,18 65,24 60,20 55,24 57,18 52,14 58,14" fill="white" opacity="0.6"/>
        </svg>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    {{-- Total Products --}}
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#f0fdf9;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
        </div>
        <div class="stat-card-label">Top Category</div>
        <div class="stat-card-value">{{ $topCategory->category ?? 'N/A' }}</div>
        <div class="stat-card-sub">{{ $topCategory->total ?? 0 }} products</div>
    </div>

    {{-- Overall Earnings --}}
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#fffbeb;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
        <div class="stat-card-label">Overall Earnings</div>
        <div class="stat-card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        <div class="stat-card-sub">Lifetime revenue</div>
    </div>

    {{-- Transactions --}}
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#f5f3ff;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"/>
                <polyline points="1 20 1 14 7 14"/>
                <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
            </svg>
        </div>
        <div class="stat-card-label">Transactions</div>
        <div class="stat-card-value">{{ $totalOrders }}</div>
        <div class="stat-card-sub">Total orders placed</div>
    </div>

    {{-- Pending Orders --}}
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#fff7ed;">
            <svg viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div class="stat-card-label">Pending Orders</div>
        <div class="stat-card-value">{{ $pendingOrders }}</div>
        <div class="stat-card-sub">Awaiting processing</div>
    </div>
</div>

{{-- Middle Row: Categories + Seller Activities --}}
<div class="dashboard-grid" style="margin-bottom:1.25rem;">

    {{-- Seller Activities --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:0.375rem;vertical-align:-2px;"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                Seller Activities
            </div>
            <a href="{{ route('admin.products.index') }}" class="panel-action">View All →</a>
        </div>
        <ul class="activity-list">
            @foreach($sellerActivities as $idx => $activity)
            @php
                $colors = ['#0d9488','#7c3aed','#d97706','#ea580c','#0284c7'];
                $color  = $colors[$idx % count($colors)];
                $initials = strtoupper(substr($activity->seller, 0, 2));
            @endphp
            <li class="activity-item">
                <div class="activity-avatar" style="background:{{ $color }};">{{ $initials }}</div>
                <div class="activity-info">
                    <div class="activity-name">{{ $activity->name }}</div>
                    <div class="activity-meta">&#64;{{ $activity->seller }} · {{ ucfirst($activity->category) }}</div>
                </div>
                <div class="activity-price">Rp {{ number_format($activity->price, 0, ',', '.') }}</div>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Category Breakdown --}}
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:0.375rem;vertical-align:-2px;"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Categories
            </div>
            <a href="{{ route('admin.products.index') }}" class="panel-action">Browse →</a>
        </div>
        <ul class="activity-list">
            @php
                $catColors = ['T-Shirts'=>'cat-tshirts','Footwear'=>'cat-footwear','Headwear'=>'cat-headwear','Hoodies'=>'cat-hoodies','Bottoms'=>'cat-bottoms','Accessories'=>'cat-accessories','Outerwear'=>'cat-outerwear'];
            @endphp
            @foreach($categories as $cat)
            <li class="activity-item">
                <div style="width:2rem;height:2rem;border-radius:0.5rem;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </div>
                <div class="activity-info">
                    <div class="activity-name">{{ $cat->category }}</div>
                    <div class="activity-meta">{{ $cat->total }} products</div>
                </div>
                <span class="cat-badge {{ $catColors[$cat->category] ?? 'cat-default' }}">{{ $cat->category }}</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- Recent Products Table --}}
<div class="panel" style="margin-bottom:1.25rem;">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:0.375rem;vertical-align:-2px;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Recent Products
        </div>
        <a href="{{ route('admin.products.index') }}" class="panel-action">View All →</a>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Seller</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Category</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentProducts as $product)
                <tr>
                    <td style="color:#94a3b8;font-family:monospace;">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,#0d9488,#0f766e);display:flex;align-items:center;justify-content:center;font-size:0.6rem;font-weight:700;color:white;flex-shrink:0;">{{ strtoupper(substr($product->seller, 0, 2)) }}</div>
                            <span style="font-size:0.775rem;color:#334155;">&#64;{{ $product->seller }}</span>
                        </div>
                    </td>
                    <td class="product-name">{{ $product->name }}</td>
                    <td>
                        <span style="font-weight:600;color:#334155;">{{ $product->qty }}</span>
                        <span style="color:#94a3b8;font-size:0.75rem;"> pcs</span>
                    </td>
                    <td>
                        @php $catMap = ['T-Shirts'=>'cat-tshirts','Footwear'=>'cat-footwear','Headwear'=>'cat-headwear','Hoodies'=>'cat-hoodies','Bottoms'=>'cat-bottoms','Accessories'=>'cat-accessories','Outerwear'=>'cat-outerwear']; @endphp
                        <span class="cat-badge {{ $catMap[$product->category] ?? 'cat-default' }}">{{ $product->category }}</span>
                    </td>
                    <td class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Orders Table --}}
<div class="panel">
    <div class="panel-header">
        <div class="panel-title">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:0.375rem;vertical-align:-2px;"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Recent Orders
        </div>
        <a href="{{ route('admin.orders.index') }}" class="panel-action">View All →</a>
    </div>
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td style="color:#94a3b8;font-family:monospace;">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <div style="width:1.75rem;height:1.75rem;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#5b21b6);display:flex;align-items:center;justify-content:center;font-size:0.6rem;font-weight:700;color:white;flex-shrink:0;">{{ strtoupper(substr($order->user, 0, 2)) }}</div>
                            <span style="font-size:0.775rem;color:#334155;">{{ $order->user }}</span>
                        </div>
                    </td>
                    <td class="product-name">{{ Str::limit($order->product, 35) }}</td>
                    <td class="product-price">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
