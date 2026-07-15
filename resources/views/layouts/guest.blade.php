<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'NekoStay') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-gray-50">
            <!-- Left branding panel -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-emerald-800 flex-col justify-between p-12 overflow-hidden">
                <!-- decorative blobs -->
                <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-emerald-700/50"></div>
                <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-emerald-600/40 translate-x-1/4 translate-y-1/4"></div>
                <a href="/" class="relative flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" class="h-11 w-11 rounded-lg object-cover shrink-0 block" alt="NekoStay logo">
                    <div>
                        <div class="font-bold text-white text-lg leading-tight">NekoStay</div>
                        <div class="text-xs text-emerald-200 leading-tight">Rescue Management</div>
                    </div>
                </a>
                <div class="relative">
                    <h1 class="text-3xl font-bold text-white leading-snug">
                        Caring for rescued cats,<br>one shelter at a time.
                    </h1>
                    <p class="mt-4 text-emerald-100 max-w-sm">
                        Track intakes, medical care, and adoption journeys in one place &mdash; so every cat finds a safe, loving home.
                    </p>
                </div>
                <div class="relative text-emerald-200 text-xs">
                    &copy; {{ now()->year }} NekoStay. All rights reserved.
                </div>
            </div>
            <!-- Right form panel -->
            <div class="flex flex-1 flex-col justify-center items-center px-6 py-12 sm:px-12">
                <div class="w-full max-w-sm">
                    <a href="/" class="flex lg:hidden items-center gap-2 justify-center mb-8">
                        <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 rounded-lg object-cover shrink-0 block" alt="NekoStay logo">
                        <div class="font-bold text-emerald-800">NekoStay</div>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
