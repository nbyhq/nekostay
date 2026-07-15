<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <title>{{ config('app.name', 'NekoStay') }} — Rescue Management</title>
        <meta name="description" content="NekoStay helps cat rescue shelters manage intakes, medical records, and adoptions in one place.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            @keyframes fade-in-up {
                0% { opacity: 0; transform: translateY(16px); }
                100% { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up { animation: fade-in-up 0.7s ease-out both; }
            .delay-200 { animation-delay: .2s; }
            .bg-paw-pattern {
                background-image: radial-gradient(currentColor 1.5px, transparent 1.5px);
                background-size: 22px 22px;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-800 scroll-smooth">

        <!-- Top Nav -->
        <header x-data="{ open: false }" class="border-b border-gray-100 bg-white/80 backdrop-blur sticky top-0 z-30">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 rounded-lg object-cover shrink-0 block" alt="NekoStay logo">
                    {{-- <div class="h-9 w-9 rounded-lg bg-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </div> --}}
                    <div>
                        <div class="font-bold text-emerald-800 leading-tight">NekoStay</div>
                        <div class="text-[11px] text-gray-500 leading-tight -mt-0.5">Rescue Management</div>
                    </div>
                </a>

                <!-- Desktop nav links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-500 hover:text-emerald-700 transition">Features</a>
                    <a href="#how-it-works" class="text-sm font-medium text-gray-500 hover:text-emerald-700 transition">How it works</a>
                    <a href="#cta" class="text-sm font-medium text-gray-500 hover:text-emerald-700 transition">Get Started</a>
                </nav>

                @if (Route::has('login'))
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-800 transition shadow-sm hover:shadow">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="text-sm font-medium text-gray-600 hover:text-emerald-700 px-3 py-2 transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-800 transition shadow-sm hover:shadow">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <!-- Mobile hamburger -->
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition" aria-label="Toggle menu">
                    <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile menu panel -->
            <div x-show="open" x-cloak x-transition class="md:hidden border-t border-gray-100 bg-white px-6 py-4 space-y-3">
                <a @click="open = false" href="#features" class="block text-sm font-medium text-gray-600 hover:text-emerald-700">Features</a>
                <a @click="open = false" href="#how-it-works" class="block text-sm font-medium text-gray-600 hover:text-emerald-700">How it works</a>
                <a @click="open = false" href="#cta" class="block text-sm font-medium text-gray-600 hover:text-emerald-700">Get Started</a>
                <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg text-center hover:bg-emerald-800 transition">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 px-4 py-2 text-center border border-gray-200 rounded-lg hover:text-emerald-700 transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg text-center hover:bg-emerald-800 transition">Get Started</a>
                        @endif
                    @endauth
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700">
            <div class="absolute inset-0 bg-paw-pattern text-white/[0.04]"></div>
            <div class="absolute -top-24 -left-24 h-72 w-72 sm:h-96 sm:w-96 rounded-full bg-emerald-600/40 blur-2xl"></div>
            <div class="absolute bottom-0 right-0 h-60 w-60 sm:h-80 sm:w-80 rounded-full bg-teal-400/20 translate-x-1/4 translate-y-1/4 blur-2xl"></div>

            <div class="relative max-w-6xl mx-auto px-6 py-16 sm:py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in-up text-center lg:text-left">
                    <span class="inline-block text-xs font-semibold tracking-wide uppercase bg-white/10 text-emerald-100 px-3 py-1 rounded-full ring-1 ring-white/10">
                        🐾 Cat Rescue &amp; Shelter Platform
                    </span>
                    <h1 class="mt-5 text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight tracking-tight">
                        Every rescued cat,<br class="hidden sm:block"> cared for and
                        <span class="bg-gradient-to-r from-amber-300 to-emerald-200 bg-clip-text text-transparent">accounted for.</span>
                    </h1>
                    <p class="mt-5 text-emerald-100/90 max-w-lg mx-auto lg:mx-0">
                        NekoStay helps shelter staff track intakes, log medical checkups, and manage adoption requests &mdash; so every cat's journey to a loving home is easy to follow.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition shadow-lg shadow-emerald-950/20 hover:-translate-y-0.5">
                                Go to Dashboard
                            </a>
                        @else
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition shadow-lg shadow-emerald-950/20 hover:-translate-y-0.5">
                                    Create an Account
                                </a>
                            @endif
                            <a href="{{ route('login') }}"
                               class="text-white font-semibold px-6 py-3 rounded-lg border border-white/30 hover:bg-white/10 transition">
                                Log in
                            </a>
                        @endauth
                    </div>

                    <div class="mt-8 flex items-center justify-center lg:justify-start gap-6 text-emerald-100/80 text-xs sm:text-sm">
                        <div class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span> No credit card needed</div>
                        <div class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span> Built for shelters</div>
                    </div>
                </div>

                <!-- Stat card -->
                <div class="relative bg-white rounded-2xl shadow-2xl shadow-emerald-950/30 p-6 lg:ml-auto lg:max-w-sm w-full mx-auto animate-fade-in-up delay-200 hover:-translate-y-1 transition-transform">
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
                        <div class="rounded-xl bg-emerald-50 p-4 hover:bg-emerald-100/70 transition">
                            <div class="text-2xl font-bold text-emerald-700">{{ \App\Models\Cat::count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Cats in system</div>
                        </div>
                        <div class="rounded-xl bg-amber-50 p-4 hover:bg-amber-100/70 transition">
                            <div class="text-2xl font-bold text-amber-700">{{ \App\Models\Cat::where('status', 'ready_for_adoption')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Ready for adoption</div>
                        </div>
                        <div class="rounded-xl bg-blue-50 p-4 hover:bg-blue-100/70 transition">
                            <div class="text-2xl font-bold text-blue-700">{{ \App\Models\Adoption::where('status', 'approved')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Cats adopted</div>
                        </div>
                        <div class="rounded-xl bg-gray-50 p-4 hover:bg-gray-100 transition">
                            <div class="text-2xl font-bold text-gray-700">{{ \App\Models\Adoption::where('status', 'pending')->count() }}</div>
                            <div class="text-xs text-gray-500 mt-1">Pending requests</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave divider -->
            <div class="relative">
                <svg class="w-full h-10 sm:h-14 text-gray-50" viewBox="0 0 1440 60" preserveAspectRatio="none" fill="currentColor">
                    <path d="M0,32 C240,60 480,0 720,16 C960,32 1200,56 1440,24 L1440,60 L0,60 Z"/>
                </svg>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="max-w-6xl mx-auto px-6 py-16 sm:py-20 scroll-mt-20">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-semibold tracking-wide uppercase text-emerald-600">Features</span>
                <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800">Everything your shelter needs, in one place</h2>
                <p class="mt-3 text-gray-500">From the moment a cat is rescued to the day it goes home, NekoStay keeps the whole team on the same page.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:border-emerald-200 hover:-translate-y-1 transition-all">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z" />
                            <circle cx="8" cy="7" r="1.5" fill="currentColor" stroke="none" />
                            <circle cx="16" cy="7" r="1.5" fill="currentColor" stroke="none" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Cat Management</h3>
                    <p class="text-sm text-gray-500 mt-2">Record every intake with photos, breed, condition, and rescue location, then track status from rescue to adoption.</p>
                </div>

                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:border-emerald-200 hover:-translate-y-1 transition-all">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M9 8h1m5 12H7a2 2 0 01-2-2V6a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414A1 1 0 0118 9.414V18a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Medical Records</h3>
                    <p class="text-sm text-gray-500 mt-2">Log checkups, diagnoses, and treatments per cat, with a visual timeline so nothing falls through the cracks.</p>
                </div>

                <div class="group bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-lg hover:border-emerald-200 hover:-translate-y-1 transition-all sm:col-span-2 md:col-span-1">
                    <div class="h-11 w-11 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 mb-4 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M12.5 3.5a3 3 0 110 6 3 3 0 010-6zM20 21v-2a4 4 0 00-3-3.87M17 3.13a4 4 0 010 7.75" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Adoption Requests</h3>
                    <p class="text-sm text-gray-500 mt-2">Review applications, approve or reject them, and let the system automatically keep each cat's status in sync.</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section id="how-it-works" class="bg-white border-y border-gray-100 scroll-mt-20">
            <div class="max-w-6xl mx-auto px-6 py-16 sm:py-20">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="text-xs font-semibold tracking-wide uppercase text-emerald-600">How it works</span>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800">From rescue to rehoming in three steps</h2>
                </div>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 relative">
                    <div class="hidden md:block absolute top-6 left-[16.5%] right-[16.5%] h-0.5 bg-emerald-100"></div>

                    <div class="relative text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center relative z-10">1</div>
                        <h3 class="mt-4 font-semibold text-gray-800">Register the cat</h3>
                        <p class="mt-2 text-sm text-gray-500 max-w-xs mx-auto">Add intake details, photos, and condition the moment a cat arrives at the shelter.</p>
                    </div>
                    <div class="relative text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center relative z-10">2</div>
                        <h3 class="mt-4 font-semibold text-gray-800">Track its care</h3>
                        <p class="mt-2 text-sm text-gray-500 max-w-xs mx-auto">Log checkups and treatments so every cat's medical history stays up to date.</p>
                    </div>
                    <div class="relative text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-emerald-700 text-white font-bold flex items-center justify-center relative z-10">3</div>
                        <h3 class="mt-4 font-semibold text-gray-800">Find a home</h3>
                        <p class="mt-2 text-sm text-gray-500 max-w-xs mx-auto">Review adoption requests and update status automatically when a match is approved.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section id="cta" class="scroll-mt-20">
            <div class="max-w-6xl mx-auto px-6 py-16 sm:py-20">
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-800 to-emerald-600 px-6 sm:px-12 py-12 sm:py-16 text-center">
                    <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-white/10"></div>
                    <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-white/10"></div>
                    <div class="relative">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white">Ready to organize your shelter's workflow?</h2>
                        <p class="mt-3 text-emerald-100 max-w-xl mx-auto">Join NekoStay and give your team one clear source of truth for every cat in your care.</p>
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition shadow-lg hover:-translate-y-0.5">Go to Dashboard</a>
                            @else
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-white text-emerald-800 font-semibold px-6 py-3 rounded-lg hover:bg-emerald-50 transition shadow-lg hover:-translate-y-0.5">Create an Account</a>
                                @endif
                                <a href="{{ route('login') }}" class="text-white font-semibold px-6 py-3 rounded-lg border border-white/30 hover:bg-white/10 transition">Log in</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-gray-100 bg-white">
            <div class="max-w-6xl mx-auto px-6 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-lg bg-emerald-600 flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                            </svg>
                        </div>
                        <span class="font-bold text-emerald-800">NekoStay</span>
                    </div>
                    <p class="mt-3 text-sm text-gray-400 max-w-xs">Helping cat rescue shelters keep every intake, checkup, and adoption organized in one place.</p>
                </div>

                <div>
                    <div class="text-sm font-semibold text-gray-700">Product</div>
                    <ul class="mt-3 space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-emerald-700 transition">Features</a></li>
                        <li><a href="#how-it-works" class="hover:text-emerald-700 transition">How it works</a></li>
                        <li><a href="#cta" class="hover:text-emerald-700 transition">Get Started</a></li>
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-semibold text-gray-700">Account</div>
                    <ul class="mt-3 space-y-2 text-sm text-gray-400">
                        @auth
                            <li><a href="{{ url('/dashboard') }}" class="hover:text-emerald-700 transition">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-emerald-700 transition">Log in</a></li>
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="hover:text-emerald-700 transition">Register</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <div>
                    <div class="text-sm font-semibold text-gray-700">About</div>
                    <ul class="mt-3 space-y-2 text-sm text-gray-400">
                        <li>Built with Laravel v{{ Illuminate\Foundation\Application::VERSION }}</li>
                        <li>&copy; {{ now()->year }} NekoStay</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-100">
                <div class="max-w-6xl mx-auto px-6 py-4 text-center text-xs text-gray-400">
                    Made with 🐾 for cats waiting for a home.
                </div>
            </div>
        </footer>
    </body>
</html>
