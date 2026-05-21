@extends('admin.layouts.admin')

@section('title', 'Settings')

@section('content')
<div style="padding: 24px; max-width: 800px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">Settings</h1>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        @csrf
        @method('PUT')

        @php
            $groups = [
                'general' => ['label' => 'General', 'fields' => ['store_name', 'store_email', 'store_phone', 'store_address']],
                'social' => ['label' => 'Social Media', 'fields' => ['facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'pinterest_url']],
                'checkout' => ['label' => 'Checkout', 'fields' => ['free_shipping_threshold', 'tax_rate', 'shipping_cost', 'currency', 'currency_symbol']],
            ];
            $allSettings = \App\Models\Setting::all()->pluck('value', 'key');
        @endphp

        @foreach ($groups as $key => $group)
            <div style="margin-bottom: 32px;">
                <h2 style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #e2e8f0;">{{ $group['label'] }}</h2>
                <div style="display: grid; gap: 16px;">
                    @foreach ($group['fields'] as $field)
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 500; color: #334155; margin-bottom: 4px; text-transform: capitalize;">
                                {{ str_replace('_', ' ', $field) }}
                            </label>
                            <input type="text" name="{{ $field }}" value="{{ old($field, $allSettings->get($field, '')) }}"
                                   style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none;">
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" style="padding: 10px 24px; background: #e11d48; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer;">Save Settings</button>
    </form>
</div>
@endsection
