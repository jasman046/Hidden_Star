<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteContent;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    /**
     * Public home / landing page
     */
    public function home()
    {
        $featuredProducts = Product::where('status', 'active')->latest()->take(8)->get();
        $categories       = Product::distinct('category')->pluck('category');

        // Load all home content (hero + gallery slots) keyed by 'key'
        $content = SiteContent::where('group', 'home')
            ->orWhere('key', 'like', 'gallery_%')
            ->get()
            ->keyBy('key');

        return view('storefront.home', compact('featuredProducts', 'categories', 'content'));
    }

    /**
     * Full shop / catalog
     */
    public function shop(Request $request)
    {
        $query = Product::where('status', 'active');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products   = $query->latest()->paginate(12);
        $categories = Product::distinct('category')->pluck('category');

        return view('storefront.shop', compact('products', 'categories'));
    }

    /**
     * Single product detail page
     */
    public function product(Product $product)
    {
        $related = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('storefront.product', compact('product', 'related'));
    }

    /**
     * About page
     */
    public function about()
    {
        // Load about gallery content keyed by 'key'
        $content = SiteContent::where('key', 'like', 'about_gallery_%')->get()->keyBy('key');

        return view('storefront.about', compact('content'));
    }
}
