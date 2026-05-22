@extends('admin.layouts.admin')
@section('title', $category->exists ? 'Edit Category' : 'New Category')
@section('content')
<x-common.page-breadcrumb pageTitle="{{ $category->exists ? 'Edit Category' : 'New Category' }}" />

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}">
            @csrf
            @if ($category->exists) @method('PUT') @endif

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
                @error('name') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="mb-5">
                <label class="block mb-1.5 text-theme-sm font-medium text-gray-700 dark:text-gray-400">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                       class="h-11 w-24 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-400 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">{{ $category->exists ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
