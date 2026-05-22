@extends('admin.layouts.admin')
@section('title', 'Contacts')
@section('content')
<x-common.page-breadcrumb pageTitle="Contact Messages" />

<div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800">
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-4 py-3 text-left text-theme-xs font-medium text-gray-500 uppercase">Subject</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-center text-theme-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-white/5 {{ !$contact->is_read ? 'bg-gray-50/50 dark:bg-white/[0.02]' : '' }}">
                        <td class="px-4 py-3.5 text-sm font-medium text-gray-800 dark:text-white/90">{{ $contact->name }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $contact->email }}</td>
                        <td class="px-4 py-3.5 text-sm text-gray-500 dark:text-gray-400">{{ $contact->subject }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            @if ($contact->is_read)
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-400">Read</span>
                            @else
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-light-50 text-blue-light-700 dark:bg-blue-light-500/15 dark:text-blue-light-500">New</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 text-sm text-center text-gray-500 dark:text-gray-400">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3.5 text-sm text-center">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-brand-500 hover:text-brand-600 font-medium">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $contacts->links() }}</div>
@endsection
