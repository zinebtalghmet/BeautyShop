@extends('admin.layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'New Product')

@section('content')
<div style="padding: 24px; max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">
        {{ $product->exists ? 'Edit Product' : 'New Product' }}
    </h1>

    <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
                @error('name') <div style="color: #dc2626; font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Category</label>
                <select name="category_id" required style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
                    <option value="">Select category</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <div style="color: #dc2626; font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Price ($)</label>
                <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Original Price ($)</label>
                <input type="number" step="0.01" min="0" name="original_price" value="{{ old('original_price', $product->original_price) }}"
                       style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Stock</label>
                <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required
                       style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Description</label>
            <textarea name="description" rows="5" required style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">{{ old('description', $product->description) }}</textarea>
            @error('description') <div style="color: #dc2626; font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-top: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Features (one per line)</label>
            <textarea name="features" rows="4" style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">{{ old('features', $product->features ? implode("\n", $product->features) : '') }}</textarea>
            <div style="font-size: 12px; color: #94a3b8; margin-top: 4px;">Enter each feature on a new line.</div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 24px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                Featured
            </label>
            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                Active
            </label>
        </div>

        <div style="margin-top: 24px; display: flex; gap: 12px;">
            <button type="submit" style="padding: 10px 24px; background: #e11d48; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                {{ $product->exists ? 'Update Product' : 'Create Product' }}
            </button>
            <a href="{{ route('admin.products.index') }}" style="padding: 10px 24px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 14px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
