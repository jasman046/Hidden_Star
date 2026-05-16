@extends('layouts.app')

@section('title', 'Orders')
@section('page-title', 'Orders')
@section('page-subtitle', 'Track and manage customer orders')

@section('content')

<div class="panel">
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-bar">
        <input
            type="text"
            name="search"
            class="filter-input"
            placeholder="Search by customer name or product…"
            value="{{ request('search') }}"
            id="orders-search"
        >
        <select name="status" class="filter-select" id="orders-status">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <button type="submit" class="filter-btn" id="orders-filter-submit">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;margin-right:0.25rem;vertical-align:-2px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Search
        </button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.orders.index') }}" style="font-size:0.8rem;color:#94a3b8;padding:0.5rem 0.75rem;text-decoration:none;" id="orders-clear">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="color:#94a3b8;font-family:monospace;">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:0.5rem;">
                            <div style="width:1.875rem;height:1.875rem;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#5b21b6);display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:white;flex-shrink:0;">{{ strtoupper(substr($order->user, 0, 2)) }}</div>
                            <span style="font-size:0.8rem;color:#334155;white-space:nowrap;">{{ $order->user }}</span>
                        </div>
                    </td>
                    <td class="product-name" style="max-width:220px;">
                        <span title="{{ $order->product }}">{{ Str::limit($order->product, 35) }}</span>
                    </td>
                    <td style="font-weight:600;color:#334155;">{{ $order->qty }}</td>
                    <td class="product-price">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                    <td style="font-size:0.775rem;color:#64748b;">{{ $order->payment_method ?? '—' }}</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td>
                        {{-- Status Update Form --}}
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}" style="display:flex;align-items:center;gap:0.375rem;">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="filter-select" style="padding:0.25rem 0.5rem;font-size:0.75rem;" id="order-status-{{ $order->id }}">
                                <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed"  {{ $order->status === 'completed'  ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" style="padding:0.25rem 0.5rem;background:#0d9488;color:white;border:none;border-radius:0.375rem;font-size:0.75rem;cursor:pointer;" id="order-update-{{ $order->id }}">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:3rem;color:#94a3b8;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 0.75rem;display:block;opacity:0.3;"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ $orders->total() }} orders
        </div>
        <div>{{ $orders->withQueryString()->links() }}</div>
    </div>
    @else
    <div class="pagination-wrapper">
        <div class="pagination-info">Showing {{ $orders->count() }} of {{ $orders->total() }} orders</div>
    </div>
    @endif
</div>

@endsection
