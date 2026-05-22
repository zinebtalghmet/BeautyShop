@extends('admin.layouts.admin')
@section('title', 'Tax Rates')
@section('content')
<x-common.page-breadcrumb pageTitle="Tax Rates" />

<div class="flex items-center justify-between mb-4">
    <div></div>
    <a href="{{ route('admin.tax-rates.create') }}"
       class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
        + New Tax Rate
    </a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-lg bg-success-50 dark:bg-success-500/10 px-4 py-3 text-sm text-success-700 dark:text-success-400">
        {{ session('success') }}
    </div>
@endif

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Country</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Region</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Label</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Rate (%)</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Priority</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($taxRates as $taxRate)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90">{{ $taxRate->country }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $taxRate->region ?? '—' }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $taxRate->label }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-800 dark:text-white/90">{{ number_format($taxRate->rate, 2) }}%</td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400">{{ $taxRate->priority }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if($taxRate->is_active)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Active</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.tax-rates.edit', $taxRate) }}"
                                   class="text-brand-500 hover:text-brand-600 font-medium">Edit</a>
                                <form action="{{ route('admin.tax-rates.destroy', $taxRate) }}" method="POST"
                                      onsubmit="return confirm('Delete this tax rate?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400 dark:text-gray-500">No tax rates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $taxRates->links() }}</div>
@endsection
