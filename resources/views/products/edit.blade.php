@extends('layouts.app')

@section('title', 'Edit: ' . $product->name)
@section('page-title', 'Edit Product')
@section('page-subtitle', $product->name)

@section('content')

<div style="margin-bottom:1rem;">
    <a href="{{ route('admin.products.index') }}" style="display:inline-flex;align-items:center;gap:.375rem;font-size:.825rem;color:#64748b;text-decoration:none;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Products
    </a>
</div>

{{-- Show all validation errors at the top --}}
@if($errors->any())
<div style="margin-bottom:1rem;padding:.875rem 1rem;background:#fee2e2;color:#991b1b;border-radius:.5rem;font-size:.825rem;">
    <strong>Please fix the following errors:</strong>
    <ul style="margin:.375rem 0 0;padding-left:1.25rem;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="panel" style="padding:1.75rem;">
    @include('products._form', [
        'formAction'  => route('admin.products.update', $product),
        'formMethod'  => 'PUT',
        'submitLabel' => 'Save Changes',
        'product'     => $product,
    ])
</div>

@endsection
