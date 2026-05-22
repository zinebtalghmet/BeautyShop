@extends('admin.layouts.admin')
@section('title', 'Orders')
@section('content')
<x-common.page-breadcrumb pageTitle="Orders" />

<div class="flex gap-2 flex-wrap mb-4">
    @php $statuses = ['' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled']; @endphp
    @foreach ($statuses as $val => $label)
        <a href="{{ request()->fullUrlWithQuery(['status' => $val ?: null, 'page' => null]) }}"
           class="inline-flex px-3.5 py-1.5 rounded-full text-sm font-medium transition-colors
                {{ request('status', '') === $val ? 'bg-brand-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-white/5 dark:text-gray-400 dark:hover:bg-white/10' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<form method="GET" class="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] mb-4 flex gap-3 items-end">
    <div class="flex-1">
        <label class="block text-theme-xs font-medium text-gray-500 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order #, name, or email..."
               class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30">
    </div>
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    <button type="submit" class="h-10 rounded-lg bg-gray-900 px-4 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white/[0.08] dark:hover:bg-white/[0.12]">Search</button>
</form>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5">
                        <td class="px-4 py-3.5 text-sm font-semibold text-gray-800 dark:text-white/90">{{ $order->order_number }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br><span class="text-theme-xs text-gray-400">{{ $order->shipping_email }}</span></td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400">{{ $order->items_count }}</td>
                        <td class="px-4 py-3.5 text-sm text-right font-semibold text-gray-800 dark:text-white/90">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->status === 'pending' ? 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-500' : '' }}
                                {{ $order->status === 'confirmed' ? 'bg-blue-light-50 text-blue-light-700 dark:bg-blue-light-500/15 dark:text-blue-light-500' : '' }}
                                {{ $order->status === 'processing' ? 'bg-theme-purple-500/10 text-theme-purple-500' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-500' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-brand-500 hover:text-brand-600 font-medium">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-sm text-gray-400">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
@endsection
