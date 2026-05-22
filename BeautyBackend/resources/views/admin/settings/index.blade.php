@extends('admin.layouts.admin')
@section('title', 'Settings')
@section('content')
<x-common.page-breadcrumb pageTitle="Settings" />

<div class="max-w-2xl">
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            @php
                $groups = [
                    'general' => ['label' => 'General', 'fields' => ['store_name', 'store_email', 'store_phone', 'store_address', 'currency', 'currency_symbol']],
                    'social' => ['label' => 'Social Media', 'fields' => ['facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'pinterest_url']],
                ];
                $allSettings = \App\Models\Setting::all()->pluck('value', 'key');
            @endphp

            @foreach ($groups as $key => $group)
                <div class="mb-6">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">{{ $group['label'] }}</h3>
                    <div class="space-y-4">
                        @foreach ($group['fields'] as $field)
                            <div>
                                <label class="block mb-1 text-theme-sm font-medium text-gray-700 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $field) }}</label>
                                <input type="text" name="{{ $field }}" value="{{ old($field, $allSettings->get($field, '')) }}"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600">Save Settings</button>
        </form>
    </div>
</div>
@endsection
