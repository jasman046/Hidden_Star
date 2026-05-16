{{--
    Shared product form partial.
    Used by both create.blade.php and edit.blade.php.
    Variables expected:
      - $product  (optional, for edit mode — filled values)
      - $categories (array)
      - $allSizes (array)
      - $formAction (string URL)
      - $formMethod ('POST' or 'PUT')
      - $submitLabel (string)
--}}

<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" id="product-form">
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">

        {{-- ── LEFT COLUMN ── --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Product Name --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Product Name *</label>
                <input type="text" name="name" id="field-name"
                       value="{{ old('name', $product->name ?? '') }}"
                       required maxlength="255"
                       placeholder="e.g. Full Sleeve Tee — Make Me Fly"
                       style="width:100%;padding:.625rem .875rem;border:1px solid {{ $errors->has('name') ? '#ef4444' : '#e2e8f0' }};border-radius:.5rem;font-size:.875rem;outline:none;font-family:Inter,sans-serif;color:#1e293b;transition:border-color .2s;"
                       onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='{{ $errors->has('name') ? '#ef4444' : '#e2e8f0' }}'">
                @error('name')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>

            {{-- Seller --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Seller Handle *</label>
                <div style="position:relative;">
                    <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.875rem;">&#64;</span>
                    <input type="text" name="seller" id="field-seller"
                           value="{{ old('seller', ltrim($product->seller ?? '', '@')) }}"
                           required maxlength="100"
                           placeholder="hidden_star_official"
                           style="width:100%;padding:.625rem .875rem .625rem 1.875rem;border:1px solid {{ $errors->has('seller') ? '#ef4444' : '#e2e8f0' }};border-radius:.5rem;font-size:.875rem;outline:none;font-family:Inter,sans-serif;color:#1e293b;"
                           onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'">
                </div>
                @error('seller')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>

            {{-- Category --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Category *</label>
                <select name="category" id="field-category" required
                        style="width:100%;padding:.625rem .875rem;border:1px solid #e2e8f0;border-radius:.5rem;font-size:.875rem;outline:none;background:#fff;color:#1e293b;cursor:pointer;"
                        onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'">
                    <option value="">Select category…</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category', $product->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @error('category')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>

            {{-- Price & Stock --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Price (USD) *</label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.875rem;">$</span>
                        <input type="number" name="price" id="field-price" step="0.01" min="0"
                               value="{{ old('price', $product->price ?? '') }}" required
                               placeholder="0.00"
                               style="width:100%;padding:.625rem .875rem .625rem 1.875rem;border:1px solid {{ $errors->has('price') ? '#ef4444' : '#e2e8f0' }};border-radius:.5rem;font-size:.875rem;outline:none;font-family:Inter,sans-serif;color:#1e293b;"
                               onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    @error('price')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Stock (pcs) *</label>
                    <input type="number" name="stock" id="field-stock" min="0"
                           value="{{ old('stock', $product->stock ?? $product->qty ?? '') }}" required
                           placeholder="0"
                           style="width:100%;padding:.625rem .875rem;border:1px solid {{ $errors->has('stock') ? '#ef4444' : '#e2e8f0' }};border-radius:.5rem;font-size:.875rem;outline:none;font-family:Inter,sans-serif;color:#1e293b;"
                           onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'">
                    @error('stock')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Status</label>
                <div style="display:flex;gap:1rem;">
                    @foreach(['active','inactive'] as $statusVal)
                    <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;color:#334155;">
                        <input type="radio" name="status" value="{{ $statusVal }}"
                               {{ old('status', $product->status ?? 'active') === $statusVal ? 'checked' : '' }}
                               style="accent-color:#0d9488;width:1rem;height:1rem;">
                        {{ ucfirst($statusVal) }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Description</label>
                <textarea name="description" id="field-description" rows="4"
                          placeholder="Describe the product — materials, fit, wash instructions…"
                          style="width:100%;padding:.625rem .875rem;border:1px solid #e2e8f0;border-radius:.5rem;font-size:.875rem;outline:none;font-family:Inter,sans-serif;color:#1e293b;resize:vertical;line-height:1.6;"
                          onfocus="this.style.borderColor='#0d9488'" onblur="this.style.borderColor='#e2e8f0'">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- ── RIGHT COLUMN ── --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem;">

            {{-- Image Upload --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.375rem;">Product Image</label>

                {{-- Current image preview (edit mode) --}}
                @if(isset($product) && $product->image_url)
                <div style="margin-bottom:.75rem;position:relative;display:inline-block;">
                    <img src="{{ $product->image_url }}" alt="Current image"
                         style="width:100%;max-height:220px;object-fit:cover;border-radius:.5rem;border:1px solid #e2e8f0;" id="current-image">
                    <div style="margin-top:.5rem;display:flex;align-items:center;gap:.5rem;">
                        <input type="checkbox" name="remove_image" id="remove-image" value="1" style="accent-color:#ef4444;">
                        <label for="remove-image" style="font-size:.775rem;color:#ef4444;cursor:pointer;">Remove current image</label>
                    </div>
                </div>
                @endif

                {{-- Upload dropzone --}}
                <div id="dropzone"
                     style="border:2px dashed #e2e8f0;border-radius:.625rem;padding:2rem;text-align:center;cursor:pointer;transition:border-color .2s,background .2s;"
                     onclick="document.getElementById('field-image').click()"
                     ondragover="event.preventDefault();this.style.borderColor='#0d9488';this.style.background='#f0fdf9';"
                     ondragleave="this.style.borderColor='#e2e8f0';this.style.background='transparent';"
                     ondrop="handleDrop(event)">
                    <div id="dropzone-preview" style="display:none;margin-bottom:.75rem;">
                        <img id="preview-img" src="" alt="Preview" style="max-height:180px;max-width:100%;border-radius:.375rem;object-fit:cover;margin:0 auto;display:block;">
                    </div>
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5" stroke-linecap="round" style="margin:0 auto .75rem;display:block;" id="dropzone-icon">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <p style="font-size:.825rem;color:#64748b;margin:0 0 .25rem;" id="dropzone-text">Drop image here or <span style="color:#0d9488;font-weight:600;">browse</span></p>
                    <p style="font-size:.72rem;color:#94a3b8;margin:0;">JPG, PNG, WEBP — max 4 MB</p>
                    <input type="file" name="image" id="field-image" accept="image/*"
                           style="display:none;" onchange="previewImage(this)">
                </div>
                @error('image')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>

            {{-- Available Sizes --}}
            <div>
                <label style="display:block;font-size:.75rem;font-weight:600;color:#475569;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.625rem;">Available Sizes</label>
                <div style="display:flex;gap:.625rem;flex-wrap:wrap;">
                    @foreach($allSizes as $size)
                    @php
                        $selectedSizes = old('sizes', isset($product) ? ($product->sizes ?? []) : []);
                        $checked = in_array($size, $selectedSizes);
                    @endphp
                    <label style="position:relative;cursor:pointer;" id="size-label-{{ strtolower($size) }}">
                        <input type="checkbox" name="sizes[]" value="{{ $size }}"
                               {{ $checked ? 'checked' : '' }}
                               style="position:absolute;opacity:0;width:0;height:0;"
                               onchange="toggleSize(this)">
                        <span id="size-box-{{ strtolower($size) }}"
                              style="display:inline-flex;align-items:center;justify-content:center;width:3rem;height:3rem;border:1px solid {{ $checked ? '#0d9488' : '#e2e8f0' }};border-radius:.375rem;font-size:.8rem;font-weight:700;color:{{ $checked ? '#fff' : '#475569' }};background:{{ $checked ? '#0d9488' : '#fff' }};transition:all .15s;user-select:none;">{{ $size }}</span>
                    </label>
                    @endforeach
                </div>
                @error('sizes')<p style="color:#ef4444;font-size:.72rem;margin-top:.25rem;">{{ $message }}</p>@enderror
            </div>

            {{-- Quick tips --}}
            <div style="background:#f8fafc;border-radius:.625rem;padding:1rem;border:1px solid #f1f5f9;">
                <div style="font-size:.72rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.5rem;">Tips</div>
                <ul style="margin:0;padding-left:1rem;font-size:.775rem;color:#64748b;line-height:1.7;">
                    <li>Use square or portrait images (3:4 ratio) for best display</li>
                    <li>Minimum recommended: 800×1000px</li>
                    <li>Accepted formats: JPG, PNG, WEBP</li>
                    <li>Leave sizes unchecked if product is one-size</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Submit / Cancel --}}
    <div style="margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid #f1f5f9;display:flex;align-items:center;gap:.75rem;">
        <button type="submit" id="btn-submit-product"
                style="padding:.65rem 1.75rem;background:#0d9488;color:#fff;border:none;border-radius:.5rem;font-size:.875rem;font-weight:600;cursor:pointer;transition:background .2s;"
                onmouseover="this.style.background='#0f766e'" onmouseout="this.style.background='#0d9488'">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.products.index') }}"
           style="padding:.65rem 1.25rem;background:#f1f5f9;color:#64748b;border-radius:.5rem;font-size:.875rem;font-weight:500;text-decoration:none;transition:background .2s;"
           onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
            Cancel
        </a>
    </div>
</form>

@push('scripts')
<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('dropzone-preview').style.display = 'block';
        document.getElementById('dropzone-icon').style.display = 'none';
        document.getElementById('dropzone-text').textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function handleDrop(e) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length) {
        const input = document.getElementById('field-image');
        const dt = new DataTransfer();
        dt.items.add(files[0]);
        input.files = dt.files;
        previewImage(input);
    }
    e.currentTarget.style.borderColor = '#e2e8f0';
    e.currentTarget.style.background = 'transparent';
}

function toggleSize(checkbox) {
    const size = checkbox.value.toLowerCase();
    const box  = document.getElementById('size-box-' + size);
    if (checkbox.checked) {
        box.style.background = '#0d9488';
        box.style.color = '#fff';
        box.style.borderColor = '#0d9488';
    } else {
        box.style.background = '#fff';
        box.style.color = '#475569';
        box.style.borderColor = '#e2e8f0';
    }
}
</script>
@endpush
