<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- CURRENT PASSWORD --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />

            <div class="relative">
                <x-text-input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="current-password" />

                <button type="button"
                        onclick="togglePassword('update_password_current_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3">
                    <img
                        src="{{ asset('icons/visibility.png') }}"
                        data-show="{{ asset('icons/visibility.png') }}"
                        data-hide="{{ asset('icons/visibility-off.png') }}"
                        class="h-5 w-5"
                        alt="Toggle Password">
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- NEW PASSWORD --}}
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />

            <div class="relative">
                <x-text-input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password" />

                <button type="button"
                        onclick="togglePassword('update_password_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3">
                    <img
                        src="{{ asset('icons/visibility.png') }}"
                        data-show="{{ asset('icons/visibility.png') }}"
                        data-hide="{{ asset('icons/visibility-off.png') }}"
                        class="h-5 w-5"
                        alt="Toggle Password">
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
                <x-text-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full pr-12"
                    autocomplete="new-password" />

                <button type="button"
                        onclick="togglePassword('update_password_password_confirmation', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3">
                    <img
                        src="{{ asset('icons/visibility.png') }}"
                        data-show="{{ asset('icons/visibility.png') }}"
                        data-hide="{{ asset('icons/visibility-off.png') }}"
                        class="h-5 w-5"
                        alt="Toggle Password">
                </button>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
