<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['key', 'label', 'image_path', 'group', 'sort_order'];

    /**
     * Get fully-qualified public URL for this content's image.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : '';
    }

    /**
     * Retrieve a single content item by key, or null.
     */
    public static function get(string $key): ?self
    {
        return static::where('key', $key)->first();
    }

    /**
     * Return the image URL for a given key, or '' if not set.
     */
    public static function imageUrl(string $key): string
    {
        $item = static::get($key);
        return $item ? $item->image_url : '';
    }
}
