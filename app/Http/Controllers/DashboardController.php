<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status', '!=', 'cancelled')->sum('price');
        $pendingOrders  = Order::where('status', 'pending')->count();

        $recentProducts = Product::latest()->take(6)->get();
        $recentOrders   = Order::latest()->take(6)->get();

        // Category breakdown
        $categories = Product::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->get();

        // Seller activities (latest 5 products by different sellers)
        $sellerActivities = Product::latest()->take(5)->get();

        $topCategory = Product::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->first();

        return view('dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentProducts',
            'recentOrders',
            'categories',
            'sellerActivities',
            'topCategory'
        ));
    }
}
