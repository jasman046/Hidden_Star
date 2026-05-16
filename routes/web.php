<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteContentController;

/*
|--------------------------------------------------------------------------
| Public Storefront Routes
|--------------------------------------------------------------------------
*/
Route::get('/',               [StorefrontController::class, 'home'])->name('home');
Route::get('/shop',           [StorefrontController::class, 'shop'])->name('shop');
Route::get('/shop/{product}', [StorefrontController::class, 'product'])->name('shop.product');
Route::get('/about',          [StorefrontController::class, 'about'])->name('about');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes  (prefixed with /admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Products — full resource CRUD
    Route::get('/products',                [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',         [ProductController::class, 'create'])->name('products.create');
    Route::post('/products',               [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}',      [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}',      [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}',   [ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders',                  [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',          [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Site Content / Appearance
    Route::get('/content',         [SiteContentController::class, 'index'])->name('content.index');
    Route::post('/content/{key}',  [SiteContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{key}',[SiteContentController::class, 'destroy'])->name('content.destroy');
});
