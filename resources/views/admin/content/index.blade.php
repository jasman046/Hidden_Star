@extends('layouts.app')

@section('title', 'Site Content')
@section('page-title', 'Site Content')
@section('page-subtitle', 'Manage images for hero, gallery, and about sections')

@section('content')

{{-- Flash --}}
@if(session('success'))
<div style="margin-bottom:1.25rem;padding:.75rem 1rem;background:#d1fae5;color:#065f46;border-radius:.5rem;font-size:.825rem;display:flex;align-items:center;gap:.5rem;">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- ═══════════════════════════════════════════════
     SECTION: HERO BANNER
════════════════════════════════════════════════ --}}
<div class="panel" style="margin-bottom:1.5rem;">
    <div class="panel-header">
        <div>
            <div class="panel-title">🏠 Home Page — Hero Banner</div>
            <div style="font-size:.725rem;color:#94a3b8;margin-top:.125rem;">Full-screen background image on the home page</div>
        </div>
    </div>
    <div style="padding:1.25rem;">
        @include('admin.content._slot', ['slot' => $contents->get('hero_banner'), 'key' => 'hero_banner', 'aspectLabel' => 'Recommended: 1920×1080px (16:9 landscape)'])
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     SECTION: HOME GALLERY
════════════════════════════════════════════════ --}}
<div class="panel" style="margin-bottom:1.5rem;">
    <div class="panel-header">
        <div>
            <div class="panel-title">🖼️ Home Page — "Our Approach" Gallery</div>
            <div style="font-size:.725rem;color:#94a3b8;margin-top:.125rem;">6 images in the masonry gallery below the product grid</div>
        </div>
    </div>
    <div style="padding:1.25rem;display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;">
        @foreach(['gallery_1','gallery_2','gallery_3','gallery_4','gallery_5','gallery_6'] as $i => $key)
        @include('admin.content._slot', [
            'slot'        => $contents->get($key),
            'key'         => $key,
            'label'       => 'Gallery Image ' . ($i + 1) . ($i === 0 ? ' (large — 2×height)' : ''),
            'aspectLabel' => $i === 0 ? '600×360px tall' : '600×180px square',
        ])
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     SECTION: ABOUT GALLERY
════════════════════════════════════════════════ --}}
<div class="panel">
    <div class="panel-header">
        <div>
            <div class="panel-title">📖 About Page — Gallery Grid</div>
            <div style="font-size:.725rem;color:#94a3b8;margin-top:.125rem;">8 images in the masonry grid on the about page</div>
        </div>
    </div>
    <div style="padding:1.25rem;display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;">
        @foreach(range(1,8) as $i)
        @php $key = 'about_gallery_' . $i; @endphp
        @include('admin.content._slot', [
            'slot'        => $contents->get($key),
            'key'         => $key,
            'label'       => 'About Image ' . $i . ($i === 1 ? ' (tall — 2×)' : ''),
            'aspectLabel' => $i === 1 ? '400×600px portrait' : '400×300px',
        ])
        @endforeach
    </div>
</div>

@endsection
