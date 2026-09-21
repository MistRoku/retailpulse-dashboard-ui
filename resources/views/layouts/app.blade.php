<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-contrast="normal">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RetailPulse Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 antialiased">
    <div x-data="shell" class="min-h-screen">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:border focus:border-gray-900 focus:bg-white focus:px-3 focus:py-2 focus:text-sm focus:font-semibold focus:text-gray-900"
        >
            Skip to content
        </a>

        @include('components.sidebar')

        <div class="flex min-h-screen flex-col lg:flex-row">
            <div class="hidden lg:block">
                @include('components.sidebar-desktop')
            </div>

            <div class="flex min-w-0 flex-1 flex-col">
                @include('components.navbar')

                <main id="main-content" class="flex-1 p-4 lg:p-6">
                    @include('components.breadcrumb', ['items' => $breadcrumbs ?? []])

                    <div class="mt-5">
                        @yield('content')
                    </div>
                </main>

                @include('components.footer')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
