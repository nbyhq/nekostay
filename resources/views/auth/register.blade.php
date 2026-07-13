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
            <h2 class="text-2xl sm:text-[28px] font-bold text-gray-900 tracking-tight">Create your account</h2>
            <p class="text-sm text-gray-500 mt-2 leading-relaxed">Join NekoStay to help track rescued cats through to adoption.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <div class="relative mt-1.5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                            <circle cx="12" cy="8.2" r="3.2"/>
                            <path d="M5 19c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <x-text-input id="name" class="block mt-1 w-full pl-11 rounded-xl bg-gray-50/70 focus:bg-white transition-colors duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

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
                    <x-text-input id="email" class="block mt-1 w-full pl-11 rounded-xl bg-gray-50/70 focus:bg-white transition-colors duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@nekostay.com" />
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
                                    required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <div class="relative mt-1.5">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-4 w-4">
                            <rect x="5" y="11" width="14" height="9" rx="2"/>
                            <path d="M8 11V7.5a4 4 0 018 0V11" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full pl-11 rounded-xl bg-gray-50/70 focus:bg-white transition-colors duration-200"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <x-primary-button class="w-full justify-center py-3 rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                {{ __('Register') }}
            </x-primary-button>

            <p class="text-center text-sm text-gray-500">
                Already registered?
                <a href="{{ route('login') }}" class="text-emerald-700 font-semibold hover:text-emerald-900 hover:underline underline-offset-4">Sign in</a>
            </p>
        </form>
    </div>
</x-guest-layout>
