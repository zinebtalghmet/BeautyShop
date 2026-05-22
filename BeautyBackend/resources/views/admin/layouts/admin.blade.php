<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — BeautyShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const saved = localStorage.getItem('theme');
                    const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = saved || system;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    if (this.theme === 'dark') { html.classList.add('dark'); } else { html.classList.remove('dark'); }
                }
            });
            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,
                toggleExpanded() { this.isExpanded = !this.isExpanded; this.isMobileOpen = false; },
                toggleMobileOpen() { this.isMobileOpen = !this.isMobileOpen; },
                setMobileOpen(val) { this.isMobileOpen = val; },
                setHovered(val) { if (window.innerWidth >= 1280 && !this.isExpanded) this.isHovered = val; }
            });
        });
    </script>
    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            if ((saved || system) === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>
</head>
<body x-data="{ loaded: true }"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1280) { $store.sidebar.setMobileOpen(false); $store.sidebar.isExpanded = false; }
            else { $store.sidebar.isMobileOpen = false; $store.sidebar.isExpanded = true; }
        });">

    <x-common.preloader />

    <div class="min-h-screen xl:flex">
        @include('admin.layouts.backdrop')
        @include('admin.layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered
            }">
            @include('admin.layouts.app-header')

            @if (session('success'))
                <div class="mx-4 mt-4 md:mx-6 md:mt-6 p-4 bg-success-50 text-success-700 rounded-lg border border-success-200 text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mx-4 mt-4 md:mx-6 md:mt-6 p-4 bg-error-50 text-error-700 rounded-lg border border-error-200 text-sm">{{ session('error') }}</div>
            @endif

            <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
@stack('scripts')
</html>
