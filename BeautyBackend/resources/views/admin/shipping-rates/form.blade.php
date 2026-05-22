@php
    $pageTitle = $shippingRate->exists ? 'Edit Shipping Rate' : 'Create Shipping Rate';
@endphp

@extends('admin.layouts.admin')

@section('content')
    <x-common.page-breadcrumb :pageTitle="$pageTitle" />

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $shippingRate->exists ? 'Edit Shipping Rate' : 'New Shipping Rate' }}</h3>
        </div>

        <form action="{{ $shippingRate->exists ? route('admin.shipping-rates.update', $shippingRate) : route('admin.shipping-rates.store') }}"
              method="POST" class="p-6">
            @csrf @if($shippingRate->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Country Code <span class="text-red-500">*</span></label>
                    <input type="text" name="country" value="{{ old('country', $shippingRate->country) }}"
                           placeholder="e.g. US, GB, *"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('country') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Region (optional)</label>
                    <input type="text" name="region" value="{{ old('region', $shippingRate->region) }}"
                           placeholder="e.g. California, Bavaria"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('region') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Label <span class="text-red-500">*</span></label>
                    <input type="text" name="label" value="{{ old('label', $shippingRate->label) }}"
                           placeholder="e.g. Standard Shipping"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('label') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Base Rate ($) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" name="base_rate"
                           value="{{ old('base_rate', $shippingRate->base_rate) }}"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('base_rate') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Free Threshold ($)</label>
                    <input type="number" step="0.01" min="0" name="free_threshold"
                           value="{{ old('free_threshold', $shippingRate->free_threshold) }}"
                           placeholder="Leave empty for no free shipping"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('free_threshold') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                    <input type="number" min="0" name="priority" value="{{ old('priority', $shippingRate->priority) }}"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('priority') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $shippingRate->is_active ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="peer h-6 w-11 rounded-full bg-gray-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-brand-500 peer-checked:after:translate-x-full dark:bg-gray-600 dark:after:bg-gray-300"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    {{ $shippingRate->exists ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('admin.shipping-rates.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
