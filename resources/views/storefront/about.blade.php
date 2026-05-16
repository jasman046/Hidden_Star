@extends('layouts.storefront')

@section('title', 'About Us — Hidden Star')
@section('meta-description', 'Learn about Hidden Star — our approach to fashion design and craftsmanship.')

@section('content')

{{-- Hero --}}
<section style="background:#111;color:#fff;padding:6rem 1.5rem;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-size:clamp(4rem,12vw,10rem);font-weight:900;color:rgba(255,255,255,.04);letter-spacing:-.02em;user-select:none;">HIDDS</div>
    <div style="position:relative;z-index:1;">
        <div style="font-size:.7rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#888;margin-bottom:1rem;">Our Story</div>
        <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;margin:0 0 1.5rem;letter-spacing:-.02em;">About Hidden Star</h1>
        <p style="font-size:1rem;color:rgba(255,255,255,.6);max-width:500px;margin:0 auto;line-height:1.8;">At Hidden Star, we blend creativity with craftsmanship to create fashion that transcends trends and stands the test of time.</p>
    </div>
</section>

{{-- Approach section --}}
<section style="max-width:900px;margin:5rem auto;padding:0 1.5rem;text-align:center;">
    <h2 style="font-size:clamp(1.25rem,3vw,2rem);font-weight:800;text-transform:uppercase;letter-spacing:.04em;margin-bottom:1.5rem;">Our Approach to Fashion Design</h2>
    <p style="font-size:.95rem;color:#555;line-height:1.9;margin-bottom:1rem;">At Hidden Star, we blend creativity with craftsmanship to create fashion that transcends trends and stands the test of time. Each design is meticulously crafted, ensuring the highest quality exquisite finish.</p>
    <p style="font-size:.95rem;color:#555;line-height:1.9;">Every piece from Hidden Star tells a story — bold graphics, premium materials, and a streetwear aesthetic that speaks to a generation that refuses to be ordinary.</p>
</section>

{{-- ═══════════════════════════════════════════
     DYNAMIC GALLERY GRID (8 slots from admin)
     PRESERVING EXACT GRID STRUCTURE
════════════════════════════════════════════ --}}
<section style="max-width:1400px;margin:0 auto;padding:0 1.5rem 5rem;">
    {{-- Same 4-col layout, aspect-ratios preserved, placeholder fallback for each slot --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:4px;">
        @php
            $fallbackColors = ['#1a1a1a','#2d2d2d','#3a3030','#222','#333','#2a2a2a','#1e1e1e','#2e2820'];
        @endphp

        @foreach(range(1,8) as $i)
        @php
            $key    = 'about_gallery_' . $i;
            $imgUrl = $content->get($key)?->image_url ?? '';
            $fb     = $fallbackColors[$i - 1];
            $ratio  = ($i % 3 === 1) ? '2/3' : '1/1';
        @endphp
        <div style="aspect-ratio:{{ $ratio }};background:{{ $fb }};overflow:hidden;position:relative;">
            @if($imgUrl)
                <img src="{{ $imgUrl }}"
                     alt="Gallery {{ $i }}"
                     style="width:100%;height:100%;object-fit:cover;display:block;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <div style="font-size:1.5rem;font-weight:900;color:rgba(255,255,255,.06);letter-spacing:.05em;">HIDDS★</div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section style="border-top:1px solid #000;border-bottom:1px solid #000;padding:4rem 1.5rem;text-align:center;margin-bottom:0;">
    <div style="font-size:.7rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#888;margin-bottom:.75rem;">Ready to explore?</div>
    <h2 style="font-size:1.75rem;font-weight:800;margin:0 0 1.5rem;">Shop the Collection</h2>
    <a href="{{ route('shop') }}" style="display:inline-flex;align-items:center;gap:.5rem;padding:.875rem 2.5rem;background:#000;color:#fff;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:background .2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
        Go To Shop
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
    </a>
</section>

@endsection
