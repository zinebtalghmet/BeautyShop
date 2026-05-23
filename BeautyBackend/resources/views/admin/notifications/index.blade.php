@extends('admin.layouts.admin')
@section('title', 'Notifications')
@section('content')
<x-common.page-breadcrumb pageTitle="Notifications" />

<div class="flex items-center justify-between mb-4">
    <div></div>
    <form method="POST" action="{{ route('admin.notifications.read-all') }}">
        @csrf @method('PUT')
        <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800 dark:bg-white/[0.08] dark:hover:bg-white/[0.12]">
            Mark All as Read
        </button>
    </form>
</div>

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Message</th>
                    <th class="px-4 py-3 text-right text-theme-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $n)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5 {{ !$n->is_read ? 'bg-gray-50 dark:bg-white/[0.02]' : '' }}">
                        <td class="px-4 py-3.5">
                            @if ($n->is_read)
                                <span class="inline-block w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                            @else
                                <span class="inline-block w-2 h-2 rounded-full bg-brand-500"></span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">
                            @switch($n->type)
                                @case('new_order') <span class="text-orange-500">📦 Order</span> @break
                                @case('new_contact') <span class="text-blue-500">✉️ Contact</span> @break
                                @case('new_review') <span class="text-purple-500">⭐ Review</span> @break
                                @default <span>{{ $n->type }}</span>
                            @endswitch
                        </td>
                        <td class="px-4 py-3.5 text-sm font-medium {{ $n->is_read ? 'text-gray-600 dark:text-gray-400' : 'text-gray-800 dark:text-white/90' }}">
                            @if ($n->link)
                                <a href="{{ $n->link }}" class="hover:text-brand-500">{{ $n->title }}</a>
                            @else
                                {{ $n->title }}
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $n->message }}</td>
                        <td class="px-4 py-3.5 text-sm text-right text-gray-500 dark:text-gray-400">{{ $n->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if (!$n->is_read)
                                <form method="POST" action="{{ route('admin.notifications.read', $n) }}" class="inline">
                                    @csrf @method('PUT')
                                    <button type="submit" class="text-brand-500 hover:text-brand-600 text-xs font-medium">Mark Read</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">Read</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">No notifications yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $notifications->links() }}</div>
@endsection
