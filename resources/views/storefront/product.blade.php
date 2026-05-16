@extends('layouts.storefront')

@section('title', $product->name . ' — Hidden Star')
@section('meta-description', Str::limit($product->description ?? 'Shop ' . $product->name . ' from Hidden Star.', 155))

@section('content')

@php
    $palettes = ['T-Shirts'=>'#e8e0d8','Footwear'=>'#d8dde8','Headwear'=>'#e5e8d8','Hoodies'=>'#d8e8e0','Bottoms'=>'#e8d8e0','Accessories'=>'#f0e8d8','Outerwear'=>'#dce8f0'];
    $bgColor  = $palettes[$product->category] ?? '#ece8e0';
    $stock    = $product->stock ?? $product->qty ?? 0;
    $sizes    = is_array($product->sizes) ? $product->sizes : [];
@endphp

<div style="max-width:1400px;margin:0 auto;padding:2.5rem 1.5rem 5rem;">

    {{-- Breadcrumb --}}
    <nav style="font-size:.75rem;color:#888;margin-bottom:2rem;display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
        <a href="{{ route('home') }}" style="color:#888;text-decoration:none;">Home</a>
        <span>/</span>
        <a href="{{ route('shop') }}" style="color:#888;text-decoration:none;">Shop</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('shop', ['category' => $product->category]) }}" style="color:#888;text-decoration:none;">{{ $product->category }}</a>
            <span>/</span>
        @endif
        <span style="color:#000;">{{ Str::limit($product->name, 40) }}</span>
    </nav>

    {{-- ── Product Main Layout ── --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;margin-bottom:5rem;" class="product-detail-grid">

        {{-- LEFT: Image --}}
        <div>
            {{-- Main image: strict aspect-ratio, object-cover --}}
            <div style="width:100%;aspect-ratio:3/4;overflow:hidden;background:{{ $bgColor }};">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         style="width:100%;height:100%;object-fit:cover;display:block;">
                @else
                    <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="rgba(0,0,0,0.12)" stroke-width="1" stroke-linecap="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span style="font-size:.7rem;font-weight:700;letter-spacing:.12em;color:rgba(0,0,0,0.2);text-transform:uppercase;">No Image</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Info --}}
        <div style="display:flex;flex-direction:column;padding-top:.5rem;">

            {{-- Category badge --}}
            <div style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#888;margin-bottom:.625rem;">{{ $product->category }}</div>

            {{-- Name --}}
            <h1 style="font-size:clamp(1.4rem,2.5vw,2rem);font-weight:800;color:#000;margin:0 0 .875rem;line-height:1.25;letter-spacing:-.02em;">{{ $product->name }}</h1>

            {{-- Price --}}
            <div style="font-size:1.75rem;font-weight:800;color:#007F7F;margin-bottom:1.5rem;letter-spacing:-.01em;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            {{-- Description --}}
            @if($product->description)
            <p style="font-size:.9rem;color:#555;line-height:1.85;margin-bottom:1.75rem;">{{ $product->description }}</p>
            @endif

            {{-- Sizes --}}
            @if(count($sizes) > 0)
            <div style="margin-bottom:1.75rem;">
                <div style="font-size:.72rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;margin-bottom:.75rem;color:#000;">Select Size</div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;" id="size-selector">
                    @foreach($sizes as $size)
                    <button type="button" onclick="selectSize(this, '{{ $size }}')"
                            style="width:3rem;height:3rem;border:1px solid #ccc;background:#fff;font-size:.78rem;font-weight:700;color:#333;cursor:pointer;transition:all .15s;"
                            onmouseover="if(!this.classList.contains('selected'))this.style.borderColor='#000'" onmouseout="if(!this.classList.contains('selected'))this.style.borderColor='#ccc'">
                        {{ $size }}
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Stock status --}}
            <div style="font-size:.8rem;margin-bottom:1.25rem;padding:.5rem .75rem;display:inline-flex;align-items:center;gap:.375rem;border:1px solid {{ $stock > 10 ? '#d1fae5' : ($stock > 0 ? '#fef3c7' : '#fee2e2') }};background:{{ $stock > 10 ? '#f0fdf4' : ($stock > 0 ? '#fffbeb' : '#fef2f2') }};color:{{ $stock > 10 ? '#065f46' : ($stock > 0 ? '#92400e' : '#991b1b') }};border-radius:.25rem;align-self:flex-start;">
                <div style="width:6px;height:6px;border-radius:50%;background:{{ $stock > 10 ? '#10b981' : ($stock > 0 ? '#f59e0b' : '#ef4444') }};"></div>
                @if($stock > 10) In Stock ({{ $stock }} available)
                @elseif($stock > 0) Low Stock — only {{ $stock }} left
                @else Out of Stock
                @endif
            </div>

            {{-- Add to Cart --}}
            <div style="display:flex;gap:.75rem;align-items:stretch;">
                @if($stock === 0)
                <button id="btn-add-to-cart" disabled
                        style="flex:1;padding:1rem 1.5rem;background:#ccc;color:#fff;border:none;font-size:.875rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:not-allowed;">
                    Out of Stock
                </button>
                @else
                <button id="btn-add-to-cart"
                        style="flex:1;padding:1rem 1.5rem;background:#000;color:#fff;border:none;font-size:.875rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
                    Add to Cart
                </button>
                @endif
                <button aria-label="Wishlist"
                        style="width:3.25rem;border:1px solid #000;background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .2s;"
                        onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='#fff'">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                </button>
            </div>

            {{-- Seller info --}}
            <div style="margin-top:2rem;padding-top:1.25rem;border-top:1px solid #eee;font-size:.8rem;color:#888;display:flex;align-items:center;gap:.625rem;">
                <div style="width:2rem;height:2rem;border-radius:50%;background:#111;display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff;flex-shrink:0;">{{ strtoupper(substr($product->seller,0,2)) }}</div>
                <div>Sold by <strong style="color:#000;">&#64;{{ $product->seller }}</strong></div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->count())
    <div style="border-top:1px solid #eee;padding-top:3rem;">
        <div style="font-size:.7rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#888;margin-bottom:.5rem;">More Like This</div>
        <h2 style="font-size:1.25rem;font-weight:700;margin:0 0 2rem;">Related Products</h2>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;" class="related-grid">
            @foreach($related as $rel)
                @include('storefront._product_card', ['product' => $rel])
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
@media (max-width:768px) {
    .product-detail-grid { grid-template-columns:1fr !important; gap:2rem !important; }
    .related-grid { grid-template-columns:repeat(2,1fr) !important; }
}
</style>
@endpush

@push('scripts')
<script>
function selectSize(btn, size) {
    document.querySelectorAll('#size-selector button').forEach(b => {
        b.classList.remove('selected');
        b.style.background = '#fff';
        b.style.color = '#333';
        b.style.borderColor = '#ccc';
    });
    btn.classList.add('selected');
    btn.style.background = '#000';
    btn.style.color = '#fff';
    btn.style.borderColor = '#000';
}
</script>
@endpush

@endsection
