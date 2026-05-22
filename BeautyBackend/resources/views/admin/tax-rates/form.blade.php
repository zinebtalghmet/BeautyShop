@php
    $pageTitle = $taxRate->exists ? 'Edit Tax Rate' : 'Create Tax Rate';
@endphp

@extends('admin.layouts.admin')

@section('content')
    <x-common.page-breadcrumb :pageTitle="$pageTitle" />

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $taxRate->exists ? 'Edit Tax Rate' : 'New Tax Rate' }}</h3>
        </div>

        <form action="{{ $taxRate->exists ? route('admin.tax-rates.update', $taxRate) : route('admin.tax-rates.store') }}"
              method="POST" class="p-6">
            @csrf @if($taxRate->exists) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Country Code <span class="text-red-500">*</span></label>
                    <input type="text" name="country" value="{{ old('country', $taxRate->country) }}"
                           placeholder="e.g. US, GB, *"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('country') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Region (optional)</label>
                    <input type="text" name="region" value="{{ old('region', $taxRate->region) }}"
                           placeholder="e.g. California, Bavaria"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('region') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Label <span class="text-red-500">*</span></label>
                    <input type="text" name="label" value="{{ old('label', $taxRate->label) }}"
                           placeholder="e.g. VAT, Sales Tax"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('label') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Rate (%) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" min="0" max="100" name="rate"
                           value="{{ old('rate', $taxRate->rate) }}"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('rate') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
                    <input type="number" min="0" name="priority" value="{{ old('priority', $taxRate->priority) }}"
                           class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-brand-500">
                    @error('priority') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center">
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $taxRate->is_active ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="peer h-6 w-11 rounded-full bg-gray-300 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:bg-white after:transition-all peer-checked:bg-brand-500 peer-checked:after:translate-x-full dark:bg-gray-600 dark:after:bg-gray-300"></div>
                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
                    {{ $taxRate->exists ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('admin.tax-rates.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
