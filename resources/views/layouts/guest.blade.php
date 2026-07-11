<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'NekoStay') }}</title>

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
                    <div class="h-11 w-11 rounded-lg bg-white/10 backdrop-blur flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
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
                        <div class="h-9 w-9 rounded-lg bg-emerald-600 flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                        </div>
                        <div class="font-bold text-emerald-800">NekoStay</div>
                    </a>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
