@extends('admin.layouts.admin')
@section('title', 'Contact Message')
@section('content')
<x-common.page-breadcrumb pageTitle="Message from {{ $contact->name }}" />

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Name</span>
                <span class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $contact->name }}</span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Email</span>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->email }}</span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Subject</span>
                <span class="text-sm text-gray-800 dark:text-white/90">{{ $contact->subject }}</span>
            </div>
            <div>
                <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-1">Date</span>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</span>
            </div>
        </div>
        <div>
            <span class="block text-theme-xs font-medium text-gray-500 uppercase mb-2">Message</span>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $contact->message }}</p>
        </div>
    </div>
</div>
@endsection
