@extends('layouts.app')

@section('title', 'Add New Product')
@section('page-title', 'Add New Product')
@section('page-subtitle', 'Fill in the details below to create a new product')

@section('content')

<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.products.index') }}" style="display:inline-flex;align-items:center;gap:.375rem;font-size:.825rem;color:#64748b;text-decoration:none;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Products
    </a>
</div>

<div class="panel" style="padding:1.75rem;">
    @include('products._form', [
        'formAction'  => route('admin.products.store'),
        'formMethod'  => 'POST',
        'submitLabel' => 'Create Product',
    ])
</div>

@endsection
