@extends('admin.layouts.admin')
@section('title', $product->exists ? 'Edit Product' : 'New Product')
@section('content')
<x-common.page-breadcrumb pageTitle="{{ $product->exists ? 'Edit Product' : 'New Product' }}" />

<div class="max-w-3xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($product->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                    @error('name') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Category</label>
                    <select name="category_id" required
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                        <option value="">Select category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Price ($)</label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Original Price ($)</label>
                    <input type="number" step="0.01" min="0" name="original_price" value="{{ old('original_price', $product->original_price) }}"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
                <div class="mb-4">
                    <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Stock</label>
                    <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                <textarea name="description" rows="5" required
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">{{ old('description', $product->description) }}</textarea>
                @error('description') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Features (one per line)</label>
                <textarea name="features" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">{{ old('features', $product->features ? implode("\n", $product->features) : '') }}</textarea>
                <p class="mt-1 text-theme-xs text-gray-500">Enter each feature on a new line.</p>
                @error('features') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6 mb-4">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    Featured
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="mb-4">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Images</label>
                <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp,image/gif"
                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:border-gray-700 dark:text-white/90 dark:file:bg-brand-500/10 dark:file:text-brand-400">
                <p class="mt-1 text-theme-xs text-gray-500">Allowed: JPG, PNG, WebP, GIF. Max 10MB each.</p>
                @error('images.*') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                <div id="image-preview" class="flex gap-3 mt-2 flex-wrap"></div>
            </div>

            @if ($product->exists && $product->images->isNotEmpty())
            <div class="mb-4">
                <label class="block mb-2 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Current Images</label>
                <div class="flex gap-3 flex-wrap">
                    @foreach ($product->images as $img)
                        <div class="relative w-[120px] h-[120px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <img src="{{ asset('storage/' . $img->image) }}" alt="Product image" class="w-full h-full object-cover">
                            <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $img]) }}" class="absolute top-1 right-1">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this image?')"
                                        class="w-6 h-6 rounded-full border-0 bg-black/60 text-white text-sm cursor-pointer flex items-center justify-center p-0 hover:bg-black/80">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="flex gap-3 mt-6">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">{{ $product->exists ? 'Update Product' : 'Create Product' }}</button>
                <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('input[name="images[]"]')?.addEventListener('change', function() {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    for (const file of this.files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'w-[100px] h-[100px] rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full h-full object-cover';
            div.appendChild(img);
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
