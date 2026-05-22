@extends('admin.layouts.admin')
@section('title', 'Reviews')
@section('content')
<x-common.page-breadcrumb pageTitle="Reviews" />

<div class="flex gap-2 flex-wrap mb-4">
    @php $filters = ['' => 'All', 'pending' => 'Pending', 'approved' => 'Approved']; @endphp
    @foreach ($filters as $val => $label)
        <a href="{{ request()->fullUrlWithQuery(['filter' => $val ?: null]) }}"
           class="inline-flex px-3.5 py-1.5 rounded-full text-sm font-medium transition-colors
                {{ request('filter', '') === $val ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/5 dark:text-gray-400 dark:hover:bg-white/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Rating</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Review</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm text-gray-800 dark:text-white/90">{{ $review->product->name ?? '—' }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $review->user->name ?? 'Guest' }}</td>
                        <td class="px-4 py-3.5 text-sm text-center text-orange-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400 max-w-[250px] truncate">{{ $review->body ?: $review->title ?: '—' }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if ($review->is_approved)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500">Approved</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if (!$review->is_approved)
                                <a href="{{ route('admin.reviews.approve', $review) }}" class="text-success-600 hover:text-success-700 font-medium">Approve</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">No reviews found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $reviews->withQueryString()->links() }}</div>
@endsection
