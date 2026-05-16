@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')
@section('page-subtitle', 'Manage your catalog')

@section('content')

{{-- Header row --}}
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.75rem;">
    <div>
        <h2 style="font-size:1rem;font-weight:700;color:#1e293b;margin:0;">All Products</h2>
        <p style="font-size:.775rem;color:#94a3b8;margin:.125rem 0 0;">{{ $products->total() }} total products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" id="btn-add-product"
       style="display:inline-flex;align-items:center;gap:.5rem;padding:.575rem 1.1rem;background:#0d9488;color:#fff;border-radius:.5rem;font-size:.825rem;font-weight:600;text-decoration:none;transition:background .2s;"
       onmouseover="this.style.background='#0f766e'" onmouseout="this.style.background='#0d9488'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add New Product
    </a>
</div>

<div class="panel">
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.products.index') }}" class="filter-bar">
        <input type="text" name="search" class="filter-input" placeholder="Search name, seller, category…" value="{{ request('search') }}" id="products-search">
        <select name="category" class="filter-select" id="products-category">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn" id="products-filter-btn">Search</button>
        @if(request('search') || request('category'))
            <a href="{{ route('admin.products.index') }}" style="font-size:.8rem;color:#94a3b8;padding:.5rem .75rem;text-decoration:none;">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:60px;">Image</th>
                    <th>ID</th>
                    <th>Seller</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width:140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    {{-- Thumbnail --}}
                    <td>
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 style="width:2.75rem;height:2.75rem;object-fit:cover;border-radius:.375rem;border:1px solid #f1f5f9;">
                        @else
                            <div style="width:2.75rem;height:2.75rem;border-radius:.375rem;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                    </td>
                    <td style="color:#94a3b8;font-family:monospace;font-size:.75rem;">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.5rem;">
                            <div style="width:1.875rem;height:1.875rem;border-radius:50%;background:linear-gradient(135deg,#0d9488,#0f766e);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff;flex-shrink:0;">{{ strtoupper(substr($product->seller, 0, 2)) }}</div>
                            <span style="font-size:.775rem;color:#334155;">&#64;{{ $product->seller }}</span>
                        </div>
                    </td>
                    <td class="product-name">{{ $product->name }}</td>
                    <td>
                        @php $stock = $product->stock ?? $product->qty; @endphp
                        <span style="font-weight:600;color:{{ $stock <= 10 ? '#ef4444' : '#334155' }};">{{ $stock }}</span>
                        <span style="color:#94a3b8;font-size:.75rem;"> pcs</span>
                    </td>
                    <td>
                        @php $catMap=['T-Shirts'=>'cat-tshirts','Footwear'=>'cat-footwear','Headwear'=>'cat-headwear','Hoodies'=>'cat-hoodies','Bottoms'=>'cat-bottoms','Accessories'=>'cat-accessories','Outerwear'=>'cat-outerwear']; @endphp
                        <span class="cat-badge {{ $catMap[$product->category] ?? 'cat-default' }}">{{ $product->category }}</span>
                    </td>
                    <td class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td><span class="badge badge-{{ $product->status }}">{{ ucfirst($product->status) }}</span></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:.375rem;">
                            <a href="{{ route('admin.products.edit', $product) }}" id="edit-product-{{ $product->id }}"
                               style="display:inline-flex;align-items:center;gap:.25rem;padding:.3rem .625rem;background:#ede9fe;color:#5b21b6;border-radius:.375rem;font-size:.72rem;font-weight:600;text-decoration:none;transition:background .15s;"
                               onmouseover="this.style.background='#ddd6fe'" onmouseout="this.style.background='#ede9fe'">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete {{ addslashes($product->name) }}? This cannot be undone.');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" id="delete-product-{{ $product->id }}"
                                    style="display:inline-flex;align-items:center;gap:.25rem;padding:.3rem .625rem;background:#fee2e2;color:#991b1b;border:none;border-radius:.375rem;font-size:.72rem;font-weight:600;cursor:pointer;transition:background .15s;"
                                    onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Del
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:3rem;color:#94a3b8;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" style="margin:0 auto .75rem;display:block;opacity:.3;"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                        No products found. <a href="{{ route('admin.products.create') }}" style="color:#0d9488;">Add one →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        <div class="pagination-info">Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}</div>
        <div>{{ $products->withQueryString()->links() }}</div>
    </div>
</div>

@endsection
