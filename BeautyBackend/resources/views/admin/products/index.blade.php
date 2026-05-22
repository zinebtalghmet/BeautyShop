@extends('admin.layouts.admin')
@section('title', 'Products')
@section('content')
<x-common.page-breadcrumb pageTitle="Products" />

<div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">+ New Product</a>
</div>

<form method="GET" class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] mb-4 flex flex-wrap gap-3 items-end">
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30 w-56">
    </div>
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Category</label>
        <select name="category" class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
            <option value="">All</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Status</label>
        <select name="status" class="h-10 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
            <option value="">All</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
    <button type="submit" class="h-10 rounded-lg bg-gray-900 px-4 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white/[0.08] dark:hover:bg-white/[0.12]">Filter</button>
</form>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Featured</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90">{{ $product->name }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-4 py-3.5 text-sm text-right text-gray-800 dark:text-white/90">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3.5 text-sm text-center" style="color: {{ $product->stock > 5 ? '#12b76a' : ($product->stock > 0 ? '#f79009' : '#f04438') }}">{{ $product->stock }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if ($product->is_featured)
                                <span class="text-orange-500">★</span>
                            @else
                                <span class="text-gray-300 dark:text-gray-600">★</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if ($product->is_active)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Active</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-brand-500 hover:text-brand-600 font-medium">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400">No products found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $products->withQueryString()->links() }}</div>
@endsection
