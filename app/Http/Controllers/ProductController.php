<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private const CATEGORIES = [
        'T-Shirts', 'Hoodies', 'Footwear', 'Headwear',
        'Bottoms', 'Accessories', 'Outerwear',
    ];

    private const SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    // ────────────────────────────────────────────────
    //  Admin: List
    // ────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('seller', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $products   = $query->latest()->paginate(10);
        $categories = self::CATEGORIES;

        return view('products.index', compact('products', 'categories'));
    }

    // ────────────────────────────────────────────────
    //  Admin: Show detail
    // ────────────────────────────────────────────────
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // ────────────────────────────────────────────────
    //  Admin: Create form
    // ────────────────────────────────────────────────
    public function create()
    {
        $categories = self::CATEGORIES;
        $allSizes   = self::SIZES;
        return view('products.create', compact('categories', 'allSizes'));
    }

    // ────────────────────────────────────────────────
    //  Admin: Store new product
    // ────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'seller'      => 'required|string|max:100',
            'category'    => 'required|in:' . implode(',', self::CATEGORIES),
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'sizes'       => 'nullable|array',
            'sizes.*'     => 'in:' . implode(',', self::SIZES),
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status'      => 'in:active,inactive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $validated['name'],
            'seller'      => $validated['seller'],
            'category'    => $validated['category'],
            'price'       => $validated['price'],
            'qty'         => $validated['stock'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'sizes'       => $validated['sizes'] ?? [],
            'image_path'  => $imagePath,
            'status'      => $request->input('status', 'active'),
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product created successfully!');
    }

    // ────────────────────────────────────────────────
    //  Admin: Edit form
    // ────────────────────────────────────────────────
    public function edit(Product $product)
    {
        $categories = self::CATEGORIES;
        $allSizes   = self::SIZES;
        return view('products.edit', compact('product', 'categories', 'allSizes'));
    }

    // ────────────────────────────────────────────────
    //  Admin: Update product
    // ────────────────────────────────────────────────
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'seller'      => 'required|string|max:100',
            'category'    => 'required|in:' . implode(',', self::CATEGORIES),
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'sizes'       => 'nullable|array',
            'sizes.*'     => 'in:' . implode(',', self::SIZES),
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status'      => 'in:active,inactive',
        ]);

        $imagePath = $product->image_path; // keep old image by default

        if ($request->hasFile('image')) {
            // Delete old image from storage
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // If user checked "remove image"
        if ($request->boolean('remove_image') && $product->image_path) {
            Storage::disk('public')->delete($product->image_path);
            $imagePath = null;
        }

        $product->update([
            'name'        => $validated['name'],
            'seller'      => $validated['seller'],
            'category'    => $validated['category'],
            'price'       => $validated['price'],
            'qty'         => $validated['stock'],
            'stock'       => $validated['stock'],
            'description' => $validated['description'] ?? null,
            'sizes'       => $validated['sizes'] ?? [],
            'image_path'  => $imagePath,
            'status'      => $request->input('status', 'active'),
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    // ────────────────────────────────────────────────
    //  Admin: Delete product
    // ────────────────────────────────────────────────
    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully!');
    }
}
