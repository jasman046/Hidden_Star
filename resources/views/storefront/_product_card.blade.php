{{--
    Shared public product card partial.
    Usage: @include('storefront._product_card', ['product' => $product])
--}}
@php
    $palettes = [
        'T-Shirts'    => '#e8e0d8',
        'Footwear'    => '#d8dde8',
        'Headwear'    => '#e5e8d8',
        'Hoodies'     => '#d8e8e0',
        'Bottoms'     => '#e8d8e0',
        'Accessories' => '#f0e8d8',
        'Outerwear'   => '#dce8f0',
    ];
    $bgColor = $palettes[$product->category] ?? '#ece8e0';
@endphp

<div class="product-card">
    {{-- Image container — strict aspect-square, uniform size --}}
    <div style="width:100%;aspect-ratio:1/1;background:{{ $bgColor }};overflow:hidden;position:relative;">

        @if($product->image_url)
            {{-- Real uploaded image via model accessor --}}
            <img src="{{ $product->image_url }}"
                 alt="{{ $product->name }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;transition:transform .4s ease;">
        @else
            {{-- Placeholder --}}
            <div style="width:100%;height:100%;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(0,0,0,0.15)" stroke-width="1" stroke-linecap="round">
                    @if($product->category === 'Footwear')
                        <path d="M2 18l7-7 4 4 4-4 5 5H2z"/><path d="M2 18v2h20v-2"/>
                    @elseif($product->category === 'Headwear')
                        <path d="M3 18h18M12 3c-5 0-8 3-8 8h16c0-5-3-8-8-8z"/>
                    @else
                        <path d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.57a1 1 0 00.99.84H5v10a2 2 0 002 2h10a2 2 0 002-2V10h1.15a1 1 0 00.99-.84l.58-3.57a2 2 0 00-1.34-2.23z"/>
                    @endif
                </svg>
                <div style="font-size:.6rem;font-weight:600;letter-spacing:.1em;color:rgba(0,0,0,0.25);text-transform:uppercase;">{{ $product->category }}</div>
            </div>
        @endif

        {{-- Teal "+" add-to-cart on hover --}}
        <button class="product-card-add" aria-label="Add to cart">+</button>
    </div>

    {{-- Card info --}}
    <div class="product-card-info">
        <div class="product-card-category">{{ $product->category }}</div>
        <div class="product-card-name">
            <a href="{{ route('shop.product', $product) }}" style="color:#000;text-decoration:none;">{{ $product->name }}</a>
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
            <div class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            @if(($product->stock ?? $product->qty ?? 0) <= 5 && ($product->stock ?? $product->qty ?? 0) > 0)
                <span style="font-size:.62rem;font-weight:700;color:#cc0000;text-transform:uppercase;letter-spacing:.05em;">Low Stock</span>
            @elseif(($product->stock ?? $product->qty ?? 0) === 0)
                <span style="font-size:.62rem;font-weight:700;color:#aaa;text-transform:uppercase;letter-spacing:.05em;">Sold Out</span>
            @endif
        </div>
    </div>
</div>
