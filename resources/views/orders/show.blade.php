@extends('layouts.app')

@section('title', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))
@section('page-title', 'Order Detail')
@section('page-subtitle', 'Order #' . str_pad($order->id, 4, '0', STR_PAD_LEFT))

@section('content')

<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.orders.index') }}" style="display:inline-flex;align-items:center;gap:0.375rem;font-size:0.825rem;color:#64748b;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#0d9488'" onmouseout="this.style.color='#64748b'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Orders
    </a>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;">
    {{-- Order Details --}}
    <div class="panel" style="padding:1.75rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
            <div>
                <div style="font-size:0.75rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.25rem;">Order ID</div>
                <div style="font-size:1.25rem;font-weight:700;color:#1e293b;font-family:monospace;">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <span class="badge badge-{{ $order->status }}" style="font-size:0.85rem;padding:0.375rem 0.875rem;">{{ ucfirst($order->status) }}</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem;">
            <div style="background:#f8fafc;border-radius:0.625rem;padding:1rem;">
                <div style="font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">Customer</div>
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <div style="width:2.25rem;height:2.25rem;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#5b21b6);display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:white;flex-shrink:0;">{{ strtoupper(substr($order->user, 0, 2)) }}</div>
                    <div style="font-size:0.9rem;font-weight:600;color:#1e293b;">{{ $order->user }}</div>
                </div>
            </div>
            <div style="background:#f8fafc;border-radius:0.625rem;padding:1rem;">
                <div style="font-size:0.7rem;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">Payment Method</div>
                <div style="font-size:0.9rem;font-weight:600;color:#1e293b;">{{ $order->payment_method ?? 'Not specified' }}</div>
            </div>
        </div>

        <div style="border:1px solid #f1f5f9;border-radius:0.625rem;overflow:hidden;margin-bottom:1.5rem;">
            <div style="background:#f8fafc;padding:0.75rem 1rem;font-size:0.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:0.07em;">Order Item</div>
            <div style="padding:1rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;">
                <div style="display:flex;align-items:center;gap:0.875rem;">
                    <div style="width:3rem;height:3rem;border-radius:0.5rem;background:linear-gradient(135deg,#f0fdf9,#ccfbf1);border:1px solid #99f6e4;display:flex;align-items:center;justify-content:center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    </div>
                    <div>
                        <div style="font-size:0.875rem;font-weight:600;color:#0d9488;">{{ $order->product }}</div>
                        <div style="font-size:0.775rem;color:#94a3b8;">Qty: {{ $order->qty }}</div>
                    </div>
                </div>
                <div style="font-size:1rem;font-weight:700;color:#0d9488;">Rp {{ number_format($order->price, 0, ',', '.') }}</div>
            </div>
            <div style="border-top:1px solid #f1f5f9;padding:0.875rem 1rem;display:flex;justify-content:space-between;">
                <span style="font-size:0.85rem;font-weight:600;color:#1e293b;">Total</span>
                <span style="font-size:1rem;font-weight:700;color:#1e293b;">Rp {{ number_format($order->price * $order->qty, 0, ',', '.') }}</span>
            </div>
        </div>

        <div style="font-size:0.775rem;color:#94a3b8;">
            Placed on {{ $order->created_at->format('d M Y, H:i') }}
        </div>
    </div>

    {{-- Update Status --}}
    <div class="panel" style="padding:1.5rem;align-self:start;">
        <div style="font-size:0.875rem;font-weight:600;color:#1e293b;margin-bottom:1rem;">Update Status</div>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
            @csrf
            @method('PATCH')
            <select name="status" class="filter-select" style="width:100%;margin-bottom:0.75rem;" id="order-detail-status">
                <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed"  {{ $order->status === 'completed'  ? 'selected' : '' }}>Completed</option>
                <option value="cancelled"  {{ $order->status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="filter-btn" style="width:100%;" id="order-detail-update">
                Update Status
            </button>
        </form>

        <div style="margin-top:1.25rem;padding-top:1.25rem;border-top:1px solid #f1f5f9;">
            <div style="font-size:0.75rem;color:#94a3b8;margin-bottom:0.5rem;font-weight:500;">Status Timeline</div>
            @php
                $timeline = ['pending','processing','completed'];
                $currentIdx = array_search($order->status, $timeline);
            @endphp
            @foreach($timeline as $tidx => $step)
            <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.5rem;">
                <div style="width:1.25rem;height:1.25rem;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;{{ ($currentIdx !== false && $tidx <= $currentIdx && $order->status !== 'cancelled') ? 'background:#0d9488;' : 'background:#e2e8f0;' }}">
                    @if($currentIdx !== false && $tidx <= $currentIdx && $order->status !== 'cancelled')
                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    @endif
                </div>
                <span style="font-size:0.775rem;{{ ($currentIdx !== false && $tidx <= $currentIdx && $order->status !== 'cancelled') ? 'color:#0d9488;font-weight:600;' : 'color:#94a3b8;' }}">{{ ucfirst($step) }}</span>
            </div>
            @endforeach
            @if($order->status === 'cancelled')
            <div style="display:flex;align-items:center;gap:0.625rem;margin-top:0.25rem;">
                <div style="width:1.25rem;height:1.25rem;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </div>
                <span style="font-size:0.775rem;color:#ef4444;font-weight:600;">Cancelled</span>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
