@extends('layouts.storefront')

@section('title', 'Shop — Hidden Star')
@section('meta-description', 'Browse the full Hidden Star collection.')

@section('content')

<div style="max-width:1400px;margin:0 auto;padding:3rem 1.5rem;">

    {{-- Heading + count --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="font-size:.7rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#888;margin-bottom:.375rem;">Catalog</div>
            <h1 style="font-size:2rem;font-weight:800;color:#000;margin:0;letter-spacing:-.02em;">All Products</h1>
        </div>
        <span style="font-size:.8rem;color:#888;">{{ $products->total() }} items</span>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('shop') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:2.5rem;padding-bottom:1.5rem;border-bottom:1px solid #eee;align-items:center;">
        <div style="flex:1;min-width:200px;display:flex;align-items:center;gap:.5rem;border:1px solid #000;padding:.5rem .875rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input name="search" type="text" placeholder="Search…" value="{{ request('search') }}" id="shop-search"
                   style="border:none;outline:none;font-size:.825rem;font-family:Inter,sans-serif;width:100%;color:#000;">
        </div>
        <select name="category" id="shop-category"
                style="border:1px solid #000;padding:.5rem 1rem;font-size:.825rem;font-family:Inter,sans-serif;background:#fff;color:#000;cursor:pointer;outline:none;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" id="shop-submit"
                style="padding:.5rem 1.5rem;background:#000;color:#fff;border:none;font-size:.775rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;cursor:pointer;">
            Search
        </button>
        @if(request('search') || request('category'))
            <a href="{{ route('shop') }}" style="font-size:.775rem;color:#888;text-decoration:none;padding:.5rem .75rem;border:1px solid #ddd;">Clear</a>
        @endif
    </form>

    {{-- Scoped responsive grid styles --}}
    <!-- <style>
        #shop-grid {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 1.5rem !important;
            font-size: 0; /* collapse whitespace text nodes */
        }
        #shop-grid > .product-card { min-width: 0; box-sizing: border-box; font-size: 1rem; }
        @media (max-width: 1024px) { #shop-grid { grid-template-columns: repeat(3, 1fr) !important; } }
        @media (max-width: 768px)  { #shop-grid { grid-template-columns: repeat(2, 1fr) !important; gap: .75rem !important; } }
    </style> -->

    {{-- Product Grid --}}
    @php
        $cardHtml = '';
        foreach ($products as $product) {
            $cardHtml .= view('storefront._product_card', ['product' => $product])->render();
        }
    @endphp
    @if($products->count())
    <div id="shop-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mt-6">
        {!! $cardHtml !!}
    </div>
    @else
    <div style="text-align:center;padding:5rem;color:#888;">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1" style="margin:0 auto 1rem;display:block;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <p>No products found matching your filters.</p>
        <a href="{{ route('shop') }}" style="color:#007F7F;text-decoration:none;font-weight:600;">Clear all filters →</a>
    </div>
    @endif

    {{-- Pagination --}}
    @if($products->hasPages())
    <div style="margin-top:3rem;padding-top:2rem;border-top:1px solid #eee;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;">
        <div style="font-size:.8rem;color:#888;">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</div>
        <div style="display:flex;gap:.375rem;">
            @if($products->onFirstPage())
                <span style="padding:.5rem .875rem;border:1px solid #eee;color:#ccc;font-size:.8rem;">← Prev</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" style="padding:.5rem .875rem;border:1px solid #000;color:#000;text-decoration:none;font-size:.8rem;">← Prev</a>
            @endif
            @foreach($products->getUrlRange(max(1,$products->currentPage()-2),min($products->lastPage(),$products->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" style="padding:.5rem .875rem;border:1px solid {{ $page==$products->currentPage()?'#000':'#eee' }};background:{{ $page==$products->currentPage()?'#000':'#fff' }};color:{{ $page==$products->currentPage()?'#fff':'#000' }};text-decoration:none;font-size:.8rem;">{{ $page }}</a>
            @endforeach
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" style="padding:.5rem .875rem;border:1px solid #000;color:#000;text-decoration:none;font-size:.8rem;">Next →</a>
            @else
                <span style="padding:.5rem .875rem;border:1px solid #eee;color:#ccc;font-size:.8rem;">Next →</span>
            @endif
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
@media (max-width:1024px) { .shop-grid { grid-template-columns:repeat(3,1fr) !important; } }
@media (max-width:640px)  { .shop-grid { grid-template-columns:repeat(2,1fr) !important; gap:.75rem !important; } }
</style>
@endpush

@endsection
