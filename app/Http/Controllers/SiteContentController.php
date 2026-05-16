<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    /**
     * All managed content slots, grouped for the UI.
     * key => label
     */
    private const SLOTS = [
        'home' => [
            'hero_banner'   => 'Hero Banner (Home page full-screen background)',
            'gallery_1'     => 'Gallery Image 1 (large tall)',
            'gallery_2'     => 'Gallery Image 2',
            'gallery_3'     => 'Gallery Image 3',
            'gallery_4'     => 'Gallery Image 4',
            'gallery_5'     => 'Gallery Image 5',
            'gallery_6'     => 'Gallery Image 6',
        ],
        'about' => [
            'about_gallery_1' => 'About Gallery 1 (tall — spans 2 rows)',
            'about_gallery_2' => 'About Gallery 2',
            'about_gallery_3' => 'About Gallery 3',
            'about_gallery_4' => 'About Gallery 4',
            'about_gallery_5' => 'About Gallery 5',
            'about_gallery_6' => 'About Gallery 6',
            'about_gallery_7' => 'About Gallery 7',
            'about_gallery_8' => 'About Gallery 8',
        ],
    ];

    /**
     * Show the Site Content management page.
     */
    public function index()
    {
        // Seed any missing rows so the UI always shows all slots
        foreach (self::SLOTS as $group => $items) {
            foreach ($items as $key => $label) {
                SiteContent::firstOrCreate(
                    ['key' => $key],
                    ['label' => $label, 'group' => $group, 'sort_order' => 0]
                );
            }
        }

        $contents = SiteContent::orderBy('group')->orderBy('sort_order')->get()->keyBy('key');

        return view('admin.content.index', compact('contents'));
    }

    /**
     * Upload a single content image.
     * POST /admin/content/{key}
     */
    public function update(Request $request, string $key)
    {
        // Validate key is allowed
        $allKeys = collect(self::SLOTS)->flatMap(fn($items) => array_keys($items))->all();
        if (!in_array($key, $allKeys)) {
            abort(422, 'Unknown content key.');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        $content = SiteContent::where('key', $key)->firstOrFail();

        // Delete old image
        if ($content->image_path) {
            Storage::disk('public')->delete($content->image_path);
        }

        // Store new image
        $path = $request->file('image')->store('content', 'public');
        $content->update(['image_path' => $path]);

        return redirect()->route('admin.content.index')
                         ->with('success', '"' . $content->label . '" updated successfully!');
    }

    /**
     * Remove an image from a content slot.
     * DELETE /admin/content/{key}
     */
    public function destroy(string $key)
    {
        $content = SiteContent::where('key', $key)->firstOrFail();

        if ($content->image_path) {
            Storage::disk('public')->delete($content->image_path);
            $content->update(['image_path' => null]);
        }

        return redirect()->route('admin.content.index')
                         ->with('success', '"' . $content->label . '" image removed.');
    }
}
