<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'NekoStay') }} — Rescue Management</title>
        <meta name="description" content="NekoStay helps cat rescue shelters manage intakes, medical records, and adoptions in one place.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800">

        <!-- Top Nav -->
        <header class="border-b border-gray-100 bg-white/80 backdrop-blur sticky top-0 z-20">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 rounded-lg object-cover shrink-0 block" alt="NekoStay logo">
                    <div>
                        <div class="font-bold text-emerald-800 leading-tight">NekoStay</div>
                        <div class="text-[11px] text-gray-500 leading-tight -mt-0.5">Rescue Management</div>
                    </div>
                </a>

                @if (Route::has('login'))
                    <nav class="flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-800 transition">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-800 transition">
                                Log in
                            </a>
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Hero -->
        <section class="relative overflow-hidden bg-emerald-800">
            <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-emerald-700/50"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-emerald-600/40 translate-x-1/4 translate-y-1/4"></div>

            <div class="relative max-w-6xl mx-auto px-6 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-block text-xs font-semibold tracking-wide uppercase bg-white/10 text-emerald-100 px-3 py-1 rounded-full">
                        Cat Rescue &amp; Shelter Platform
                    </span>
                    <h1 class="mt-5 text-4xl lg:text-5xl font-bold text-white leading-tight">
                        Every rescued cat,<br> cared for and accounted for.
                    </h1>
                    <p class="mt-5 text-emerald-100 max-w-lg">
                        NekoStay helps shelter staff track intakes, log medical checkups, and manage adoption requests &mdash; so every cat's journey to a loving home is easy to follow.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition">
                                Go to Dashboard
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition">
                                    Create an Account
                                </a>
                            @endif
                            <a href="{{ route('login') }}"
                               class="text-white font-semibold px-6 py-3 rounded-lg border border-white/30 hover:bg-white/10 transition">
                                Log in
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Stat card -->
                <div class="relative bg-white rounded-2xl shadow-xl p-6 lg:ml-auto lg:max-w-sm w-full">
                    <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="h-11 w-11 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                            🐾
                        </div>
                        <div>
                            <div class="font-semibold text-gray-800">Shelter Overview</div>
                            <div class="text-xs text-gray-400">Live snapshot</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div class="rounded-xl bg-emerald-50 p-4">
                            <div class="text-2xl font-bold text-emerald-700">{{ \App\Models\Cat::count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Cats in system</div>
                        </div>
                        <div class="rounded-xl bg-amber-50 p-4">
                            <div class="text-2xl font-bold text-amber-700">{{ \App\Models\Cat::where('status', 'ready_for_adoption')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Ready for adoption</div>
                        </div>
                        <div class="rounded-xl bg-blue-50 p-4">
                            <div class="text-2xl font-bold text-blue-700">{{ \App\Models\Adoption::where('status', 'approved')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Cats adopted</div>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4">
                            <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Adoption::where('status', 'pending')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Pending requests</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="max-w-6xl mx-auto px-6 py-20">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Everything your shelter needs, in one place</h2>
                <p class="mt-3 text-gray-500">From the moment a cat is rescued to the day it goes home, NekoStay keeps the whole team on the same page.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z" />
                            <circle cx="8" cy="7" r="1.5" fill="currentColor" stroke="none" />
                            <circle cx="16" cy="7" r="1.5" fill="currentColor" stroke="none" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Cat Management</h3>
                    <p class="text-sm text-gray-500 mt-2">Record every intake with photos, breed, condition, and rescue location, then track status from rescue to adoption.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h1m5 12H7a2 2 0 01-2-2V6a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414A1 1 0 0118 9.414V18a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Medical Records</h3>
                    <p class="text-sm text-gray-500 mt-2">Log checkups, diagnoses, and treatments per cat, with a visual timeline so nothing falls through the cracks.</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M12.5 3.5a3 3 0 110 6 3 3 0 010-6zM20 21v-2a4 4 0 00-3-3.87M17 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Adoption Requests</h3>
                    <p class="text-sm text-gray-500 mt-2">Review applications, approve or reject them, and let the system automatically keep each cat's status in sync.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-100 bg-white">
            <div class="max-w-6xl mx-auto px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-gray-400">
                <div class="flex items-center gap-2">
                    <div class="h-6 w-6 rounded bg-emerald-600 flex items-center justify-center">
                        <svg class="h-3.5 w-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div>
                    <span>&copy; {{ now()->year }} NekoStay. All rights reserved.</span>
                </div>
                <span>Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
            </div>
        </footer>
    </body>
</html>
