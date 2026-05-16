@extends('layouts.app')

@section('title', $product->name)
@section('page-title', 'Product Detail')
@section('page-subtitle', $product->name)

@section('content')

<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.products.index') }}" style="display:inline-flex;align-items:center;gap:0.375rem;font-size:0.825rem;color:#64748b;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#0d9488'" onmouseout="this.style.color='#64748b'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Products
    </a>
</div>

<div class="panel" style="padding:1.75rem;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
        {{-- Product Image Placeholder --}}
        <div style="background:linear-gradient(135deg,#f0fdf9,#ccfbf1);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;min-height:280px;border:1px solid #99f6e4;">
            <div style="text-align:center;color:#0d9488;opacity:0.5;">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 0.75rem;display:block;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                <div style="font-size:0.8rem;font-weight:600;">{{ $product->category }}</div>
            </div>
        </div>

        {{-- Product Info --}}
        <div>
            @php $catMap = ['T-Shirts'=>'cat-tshirts','Footwear'=>'cat-footwear','Headwear'=>'cat-headwear','Hoodies'=>'cat-hoodies','Bottoms'=>'cat-bottoms','Accessories'=>'cat-accessories','Outerwear'=>'cat-outerwear']; @endphp
            <span class="cat-badge {{ $catMap[$product->category] ?? 'cat-default' }}" style="margin-bottom:0.75rem;display:inline-block;">{{ $product->category }}</span>
            <h1 style="font-size:1.5rem;font-weight:700;color:#1e293b;margin-bottom:0.5rem;line-height:1.3;">{{ $product->name }}</h1>
            <div style="font-size:0.85rem;color:#64748b;margin-bottom:1.25rem;">
                Sold by <strong style="color:#0d9488;">@{{ $product->seller }}</strong>
            </div>

            <div style="font-size:2rem;font-weight:800;color:#0d9488;margin-bottom:1.25rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            @if($product->description)
            <p style="font-size:0.875rem;color:#64748b;line-height:1.7;margin-bottom:1.25rem;">{{ $product->description }}</p>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="background:#f8fafc;border-radius:0.625rem;padding:1rem;">
                    <div style="font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.25rem;">Quantity in Stock</div>
                    <div style="font-size:1.25rem;font-weight:700;color:{{ $product->qty <= 10 ? '#ef4444' : '#1e293b' }};">{{ $product->qty }} pcs</div>
                </div>
                <div style="background:#f8fafc;border-radius:0.625rem;padding:1rem;">
                    <div style="font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.25rem;">Status</div>
                    <span class="badge badge-{{ $product->status }}" style="font-size:0.8rem;">{{ ucfirst($product->status) }}</span>
                </div>
            </div>

            <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #f1f5f9;">
                <div style="font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.25rem;">Added</div>
                <div style="font-size:0.85rem;color:#334155;">{{ $product->created_at->format('d M Y, H:i') }}</div>
            </div>
        </div>
    </div>
</div>

@endsection
