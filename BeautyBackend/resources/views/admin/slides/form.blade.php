@extends('admin.layouts.admin')

@section('title', $slide->exists ? 'Edit Slide' : 'New Slide')

@section('content')
<div style="padding: 24px; max-width: 640px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">
        {{ $slide->exists ? 'Edit Slide' : 'New Slide' }}
    </h1>

    <form method="POST" action="{{ $slide->exists ? route('admin.slides.update', $slide) : route('admin.slides.store') }}" enctype="multipart/form-data" style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        @csrf
        @if ($slide->exists) @method('PUT') @endif

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Title</label>
            <input type="text" name="title" value="{{ old('title', $slide->title) }}" required
                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Subtitle</label>
            <textarea name="subtitle" rows="2" style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">{{ old('subtitle', $slide->subtitle) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Button Text</label>
            <input type="text" name="button_text" value="{{ old('button_text', $slide->button_text) }}"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Button Link</label>
            <input type="text" name="button_link" value="{{ old('button_link', $slide->button_link) }}"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Image</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif"
                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
            <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Allowed: JPG, PNG, WebP, GIF. Max 10MB.</div>
            @error('image') <div style="color: #dc2626; font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
            @if ($slide->exists && $slide->image)
                <div style="margin-top: 8px;">
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Current slide image"
                         style="max-width: 200px; max-height: 120px; border-radius: 6px; border: 1px solid #e2e8f0;">
                </div>
            @endif
            <div id="slide-image-preview" style="margin-top: 8px;"></div>
        </div>

        <div style="margin-bottom: 20px; display: flex; gap: 20px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $slide->sort_order) }}" min="0"
                       style="width: 100px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            <div style="display: flex; align-items: end; padding-bottom: 10px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="padding: 10px 24px; background: #e11d48; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                {{ $slide->exists ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.slides.index') }}" style="padding: 10px 24px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 14px;">Cancel</a>
        </div>
    </form>
</div>

<script>
document.querySelector('input[name="image"]')?.addEventListener('change', function() {
    const preview = document.getElementById('slide-image-preview');
    preview.innerHTML = '';
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'max-width: 200px; max-height: 120px; border-radius: 6px; border: 1px solid #e2e8f0;';
            preview.appendChild(img);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endsection
