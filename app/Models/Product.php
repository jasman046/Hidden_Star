<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'seller', 'category', 'price', 'qty', 'stock',
        'image', 'image_path', 'status', 'description', 'sizes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sizes' => 'array',
    ];

    /**
     * Effective stock: uses `stock` if set, falls back to `qty`
     */
    public function getEffectiveStockAttribute(): int
    {
        return $this->stock ?? $this->qty ?? 0;
    }

    /**
     * Returns the public URL for the product image
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return ''; // empty — views will show placeholder
    }
}
