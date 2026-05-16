{{--
    Reusable upload slot card — fully self-contained.
    Variables:
      $slot        — SiteContent model instance (or null)
      $key         — string, the content key
      $label       — optional label override
      $aspectLabel — recommended size hint string
--}}
@php
    $displayLabel = $label ?? ($slot?->label ?? $key);
    $savedUrl     = $slot?->image_url ?? '';
    // Safe JS identifier: replace hyphens/underscores to keep valid
    $jsId = preg_replace('/[^a-zA-Z0-9]/', '_', $key);
@endphp

<div style="border:1px solid #f1f5f9;border-radius:.625rem;overflow:hidden;background:#fafbfc;">

    {{-- ── Preview area ── always rendered so JS can reach the <img> --}}
    <div id="preview-wrap-{{ $jsId }}"
         style="aspect-ratio:4/3;background:#f1f5f9;overflow:hidden;position:relative;">

        {{-- Actual image (saved OR live-preview; hidden if no src yet) --}}
        <img id="preview-img-{{ $jsId }}"
             src="{{ $savedUrl }}"
             alt="{{ $displayLabel }}"
             style="width:100%;height:100%;object-fit:cover;display:{{ $savedUrl ? 'block' : 'none' }};">

        {{-- Placeholder — shown when there is no image --}}
        <div id="preview-placeholder-{{ $jsId }}"
             style="width:100%;height:100%;display:{{ $savedUrl ? 'none' : 'flex' }};flex-direction:column;align-items:center;justify-content:center;gap:.5rem;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
            </svg>
            <span style="font-size:.65rem;color:#cbd5e1;">No image</span>
        </div>

        {{-- Red ✕ remove button — only shown when a saved image exists --}}
        @if($savedUrl)
        <form method="POST" action="{{ route('admin.content.destroy', $key) }}"
              onsubmit="return confirm('Remove this image?')"
              style="position:absolute;top:.5rem;right:.5rem;z-index:2;">
            @csrf @method('DELETE')
            <button type="submit"
                    style="width:1.75rem;height:1.75rem;border-radius:50%;background:rgba(239,68,68,.9);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;"
                    title="Remove image">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </form>
        @endif
    </div>

    {{-- ── Label + Upload Form ── --}}
    <div style="padding:.75rem;">
        <div style="font-size:.72rem;font-weight:600;color:#334155;margin-bottom:.125rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
             title="{{ $displayLabel }}">{{ $displayLabel }}</div>
        <div style="font-size:.65rem;color:#94a3b8;margin-bottom:.625rem;">{{ $aspectLabel ?? '' }}</div>

        <form method="POST"
              action="{{ route('admin.content.update', $key) }}"
              enctype="multipart/form-data"
              id="form-{{ $jsId }}">
            @csrf

            <div style="display:flex;gap:.375rem;align-items:center;">
                {{-- Clickable upload label --}}
                <label for="file-{{ $jsId }}"
                       style="flex:1;display:flex;align-items:center;gap:.375rem;padding:.4rem .625rem;
                              border:1px dashed #cbd5e1;border-radius:.375rem;cursor:pointer;
                              font-size:.72rem;color:#64748b;transition:border-color .2s;overflow:hidden;"
                       onmouseover="this.style.borderColor='#0d9488'"
                       onmouseout="this.style.borderColor='#cbd5e1'">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                    <span id="file-label-{{ $jsId }}" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $savedUrl ? 'Replace…' : 'Choose image…' }}
                    </span>
                </label>

                {{-- Hidden file input --}}
                <input type="file"
                       name="image"
                       id="file-{{ $jsId }}"
                       accept="image/jpeg,image/png,image/webp"
                       style="display:none;"
                       onchange="slotFileChange(this, '{{ $jsId }}')">

                {{-- Save button — revealed by JS after file is chosen --}}
                <button type="submit"
                        id="save-{{ $jsId }}"
                        style="display:none;padding:.4rem .875rem;background:#0d9488;color:#fff;
                               border:none;border-radius:.375rem;font-size:.72rem;font-weight:600;
                               cursor:pointer;white-space:nowrap;transition:background .15s;"
                        onmouseover="this.style.background='#0f766e'"
                        onmouseout="this.style.background='#0d9488'">
                    Save ↑
                </button>
            </div>

            @if($errors->has('image'))
            <p style="color:#ef4444;font-size:.65rem;margin-top:.375rem;">{{ $errors->first('image') }}</p>
            @endif
        </form>
    </div>
</div>

{{-- ── Self-contained JS (inline, no @push dependency) ── --}}
<script>
(function() {
    /**
     * Called when a file input inside a slot card changes.
     * @param {HTMLInputElement} input
     * @param {string} id  — sanitised JS identifier (underscores only)
     */
    function slotFileChange(input, id) {
        if (!input.files || !input.files[0]) return;

        var file  = input.files[0];
        var img   = document.getElementById('preview-img-'         + id);
        var ph    = document.getElementById('preview-placeholder-' + id);
        var lbl   = document.getElementById('file-label-'          + id);
        var btn   = document.getElementById('save-'                + id);

        // Live preview using object URL
        if (img) {
            // Revoke any previous object URL to avoid memory leaks
            if (img._objectUrl) URL.revokeObjectURL(img._objectUrl);
            var objectUrl = URL.createObjectURL(file);
            img._objectUrl = objectUrl;
            img.src        = objectUrl;
            img.style.display = 'block';
        }

        // Hide placeholder
        if (ph) ph.style.display = 'none';

        // Update text label to filename
        if (lbl) lbl.textContent = file.name;

        // Show Save button
        if (btn) btn.style.display = 'inline-block';
    }

    // Expose to inline onchange="" attribute
    window.slotFileChange = slotFileChange;
})();
</script>
