<x-guest-layout>
    <style>
        @keyframes ns-rise {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .ns-rise { animation: ns-rise .5s cubic-bezier(.16,1,.3,1) both; }

        @media (prefers-reduced-motion: reduce) {
            .ns-rise { animation: none !important; opacity: 1 !important; transform: none !important; }
        }
    </style>

    <div class="ns-rise">
        <div class="mb-8">
            <h2 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight">Welcome back</h2>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Sign in to manage rescued cats, medical records, and adoptions.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <div class="relative mt-1.5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                            <rect x="3" y="5.5" width="18" height="13" rx="2.2"/>
                            <path d="M3.5 7.2l8.5 5.8 8.5-5.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <x-text-input id="email" class="block mt-1 w-full pl-11 rounded-xl bg-gray-50/70 focus:bg-white transition-colors duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@nekostay.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative mt-1.5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                            <rect x="5" y="11" width="14" height="9" rx="2"/>
                            <path d="M8 11V7.5a4 4 0 018 0V11" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <x-text-input id="password" class="block mt-1 w-full pl-11 rounded-xl bg-gray-50/70 focus:bg-white transition-colors duration-200"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-800 transition-colors">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-emerald-700 hover:text-emerald-900 hover:underline underline-offset-4" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center py-3 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-emerald-700 font-semibold hover:text-emerald-900 hover:underline underline-offset-4">Sign up</a>
                </p>
            @endif
        </form>
    </div>
</x-guest-layout>
