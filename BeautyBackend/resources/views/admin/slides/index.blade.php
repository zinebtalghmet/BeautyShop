@extends('admin.layouts.admin')
@section('title', 'Slides')
@section('content')
<x-common.page-breadcrumb pageTitle="Slides" />

<div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="{{ route('admin.slides.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">+ New Slide</a>
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Image</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Button</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Sort</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Active</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($slides as $slide)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5">
                            @if ($slide->image)
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="w-16 h-10 object-cover rounded border border-gray-200 dark:border-gray-700">
                            @else
                                <span class="text-theme-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90">{{ $slide->title }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $slide->button_text ?: '—' }}</td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400">{{ $slide->sort_order }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if ($slide->is_active)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Active</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <a href="{{ route('admin.slides.edit', $slide) }}" class="text-brand-500 hover:text-brand-600 font-medium">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">No slides created.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
