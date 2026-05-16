@extends('layouts.storefront')

@section('title', 'Hidden Star — Premium Streetwear')
@section('meta-description', 'Welcome to Hidden Star. Shop the latest streetwear — tees, hoodies, footwear and more.')

@section('content')

{{-- ═══════════════════════════════════════════
     HERO BANNER (full viewport)
════════════════════════════════════════════ --}}
@php $heroBg = $content->get('hero_banner')?->image_url ?? ''; @endphp

<section style="position:relative;width:100%;height:100vh;background:linear-gradient(160deg,#111 0%,#1e1a1a 60%,#2a2020 100%);overflow:hidden;display:flex;align-items:flex-end;">

    {{-- ── Hero image: full opacity, responsive cover fill ── --}}
    @if($heroBg)
    <img src="{{ $heroBg }}"
         alt="Hidden Star Hero Banner"
         style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center;display:block;z-index:0;">
    {{-- Bottom-only vignette — keeps CTA legible without dimming the whole image --}}
    <div style="position:absolute;inset:0;z-index:1;background:linear-gradient(to top,rgba(0,0,0,.6) 0%,transparent 45%);pointer-events:none;"></div>
    @endif

    {{-- Slide dots (decorative) --}}
    <div style="position:absolute;bottom:2rem;right:2rem;display:flex;gap:.5rem;align-items:center;z-index:3;">
        <div style="width:20px;height:2px;background:#fff;border-radius:1px;"></div>
        <div style="width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.5);"></div>
        <div style="width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,.5);"></div>
    </div>

    {{-- Go To Shop CTA --}}
    <a href="{{ route('shop') }}" class="hero-btn" style="position:relative;z-index:3;">
        Go To Shop
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
</section>

{{-- ═══════════════════════════════════════════
     WELCOME + FEATURED PRODUCTS
════════════════════════════════════════════ --}}
<style>
    #featured-section { max-width:1400px; margin:0 auto; padding:4rem 1.5rem 3rem; }
    #featured-grid {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 1.5rem !important;
        font-size: 0; /* collapse whitespace text nodes */
    }
    #featured-grid > .product-card { min-width: 0; box-sizing: border-box; font-size: 1rem; }
    @media (max-width: 1024px) { #featured-grid { grid-template-columns: repeat(3, 1fr) !important; } }
    @media (max-width: 768px)  { #featured-grid { grid-template-columns: repeat(2, 1fr) !important; gap: .75rem !important; } }
</style>

<section id="featured-section">

    {{-- Heading row --}}
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
        <div>
            <div style="font-size:.7rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#888;margin-bottom:.375rem;">New Arrivals</div>
            <h2 style="font-size:clamp(1.5rem,3vw,2rem);font-weight:800;color:#000;margin:0;letter-spacing:-.02em;">Welcome to Hidden Star</h2>
        </div>
        <a href="{{ route('shop') }}" style="font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#000;text-decoration:none;border-bottom:1px solid #000;padding-bottom:2px;">View All →</a>
    </div>

    {{-- 4-col grid: cards rendered without whitespace between them --}}
    @php
        $cardHtml = '';
        foreach ($featuredProducts as $product) {
            ob_start();
            echo view('storefront._product_card', ['product' => $product])->render();
            $cardHtml .= ob_get_clean();
        }
    @endphp
    <div id="featured-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 mt-6">
        @if($featuredProducts->isEmpty())
            <div style="grid-column:span 4;text-align:center;padding:3rem;color:#888;">No products yet.</div>
        @else
            {!! $cardHtml !!}
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════
     BRAND APPROACH + DYNAMIC GALLERY
════════════════════════════════════════════ --}}
<section style="max-width:1400px;margin:0 auto;padding:2rem 1.5rem 3rem;text-align:center;">
    <h2 style="font-size:clamp(1.1rem,2.5vw,1.5rem);font-weight:800;letter-spacing:.04em;text-transform:uppercase;margin-bottom:.75rem;">Our Approach to Fashion Design</h2>
    <p style="font-size:.9rem;color:#555;line-height:1.8;max-width:500px;margin:0 auto 2.5rem;">At Hidden Star, we blend creativity with craftsmanship to create fashion that transcends trends and stands the test of time.</p>

    {{-- ── Dynamic Gallery Grid ── 4 columns, first image spans 2 rows --}}
    <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr;grid-auto-rows:180px;gap:4px;">

        {{-- Slot 1: Large (spans 2 rows) --}}
        @php $g1 = $content->get('gallery_1')?->image_url ?? ''; @endphp
        <div style="grid-row:span 2;background:#1a1a1a;overflow:hidden;position:relative;">
            @if($g1)
                <img src="{{ $g1 }}" alt="Gallery 1" style="width:100%;height:100%;object-fit:cover;display:block;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <div style="font-size:2.5rem;font-weight:900;color:rgba(255,255,255,.06);letter-spacing:.05em;user-select:none;">★HIDDS★</div>
                </div>
            @endif
        </div>

        {{-- Slots 2–6: Small squares --}}
        @foreach([2,3,4,5,6] as $i)
        @php
            $key = 'gallery_' . $i;
            $gUrl = $content->get($key)?->image_url ?? '';
            $fallbackColors = ['#2d2d2d','#333','#222','#3a3030','#2a2a2a'];
            $fb = $fallbackColors[$i - 2];
        @endphp
        <div style="background:{{ $fb }};overflow:hidden;position:relative;">
            @if($gUrl)
                <img src="{{ $gUrl }}" alt="Gallery {{ $i }}" style="width:100%;height:100%;object-fit:cover;display:block;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <div style="font-size:.8rem;font-weight:900;color:rgba(255,255,255,.06);letter-spacing:.1em;user-select:none;">★</div>
                </div>
            @endif
        </div>
        @endforeach

    </div>
</section>

{{-- ═══════════════════════════════════════════
     CATEGORIES STRIP
════════════════════════════════════════════ --}}
<section style="border-top:1px solid #eee;border-bottom:1px solid #eee;padding:2rem 1.5rem;">
    <div style="max-width:1400px;margin:0 auto;text-align:center;">
        <div style="font-size:.7rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:#888;margin-bottom:1rem;">Shop by Category</div>
        <div style="display:flex;flex-wrap:wrap;gap:.625rem;justify-content:center;">
            @foreach($categories as $cat)
            <a href="{{ route('shop', ['category' => $cat]) }}"
               style="padding:.45rem 1.1rem;border:1px solid #000;font-size:.72rem;font-weight:600;letter-spacing:.07em;text-transform:uppercase;color:#000;text-decoration:none;transition:all .2s;"
               onmouseover="this.style.background='#000';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#000'">{{ $cat }}</a>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
@push('styles')
<style>
@media (max-width: 1024px) {
    .product-grid-home { grid-template-columns: repeat(3,1fr) !important; }
}
@media (max-width: 640px) {
    .product-grid-home { grid-template-columns: repeat(2,1fr) !important; gap: .75rem !important; }
}
</style>
@endpush

@endsection
