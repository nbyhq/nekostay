<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800">Profile Management</h2>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-6">

        {{-- Profile Information Card --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-800">Profile Information</h3>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                    Active Account
                </span>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('patch')

                <div class="flex items-start gap-6">
                    <div class="flex flex-col items-center gap-2">
                        <div class="relative">
                            @if ($user->photo)
                                <img src="{{ str_starts_with($user->photo, 'http') ? $user->photo : Storage::url($user->photo) }}"
                                     class="h-20 w-20 rounded-full object-cover border">
                            @else
                                <div class="h-20 w-20 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-semibold border">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <label for="photo" class="absolute -bottom-1 -right-1 h-7 w-7 rounded-full bg-emerald-700 text-white flex items-center justify-center cursor-pointer hover:bg-emerald-800">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </label>
                            <input type="file" name="photo" id="photo" accept="image/*" class="hidden">
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-semibold text-gray-800">Staff Member</div>
                            <div class="text-xs text-emerald-700 font-medium">Role: {{ ucfirst($user->getRoleNames()->first() ?? '-') }}</div>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('photo')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <p class="text-sm mt-2 text-gray-600">
                                    {{ __('Your email address is unverified.') }}
                                    <button form="send-verification" class="underline hover:text-gray-900">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600">
                            {{ __('Saved.') }}
                        </p>
                    @endif
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg">
                        Save Info
                    </button>
                </div>
            </form>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
        </div>

        {{-- Security & Privacy Card --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-800 mb-1">Security &amp; Privacy</h3>
            <p class="text-sm text-gray-500 mb-6">To update your password, please verify your current credentials first.</p>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="update_password_password" :value="__('New Password')" />
                        <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-lg px-4 py-3">
                    ⓘ Password must be at least 8 characters long. For enhanced rescue data security, consider including numbers and special characters.
                </div>

                <div class="flex items-center justify-end gap-4 pt-2">
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600">
                            {{ __('Saved.') }}
                        </p>
                    @endif
                    <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone Card --}}
        <div class="bg-red-50 border border-red-100 rounded-xl shadow-sm p-6">
            <div class="flex items-center gap-2 mb-1">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="font-semibold text-red-700">Danger Zone</h3>
            </div>
            <p class="text-sm text-red-600/80 mb-4">
                Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.
            </p>

            <button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="bg-white border border-red-300 text-red-600 text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-red-100 transition"
            >
                Delete Account
            </button>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-danger-button class="ms-3">
                            {{ __('Delete Account') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('photo')?.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                this.closest('form').querySelector('button[type="submit"]').textContent = 'Save Info (photo selected)';
            }
        });
    </script>
    @endpush
</x-app-layout>
