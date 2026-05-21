@extends('admin.layouts.admin')

@section('title', $category->exists ? 'Edit Category' : 'New Category')

@section('content')
<div style="padding: 24px; max-width: 640px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">
        {{ $category->exists ? 'Edit Category' : 'New Category' }}
    </h1>

    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
            @error('name') <div style="color: #dc2626; font-size: 13px; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Description</label>
            <textarea name="description" rows="3" style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">{{ old('description', $category->description) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 6px;">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                   style="width: 100px; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #334155; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                Active
            </label>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="padding: 10px 24px; background: #e11d48; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">
                {{ $category->exists ? 'Update' : 'Create' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" style="padding: 10px 24px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 14px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
