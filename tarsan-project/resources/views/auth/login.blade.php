<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input
                    id="login_password"
                    class="block mt-1 w-full pr-12"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password" />

                <button type="button"
                        onclick="togglePassword('login_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-3">
                    <img
                        src="{{ asset('icons/visibility.png') }}"
                        data-show="{{ asset('icons/visibility.png') }}"
                        data-hide="{{ asset('icons/visibility-off.png') }}"
                        class="h-5 w-5"
                        alt="Toggle Password">
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>



        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('img');

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = icon.dataset.hide;
            } else {
                input.type = 'password';
                icon.src = icon.dataset.show;
            }
        }
    </script>


</x-guest-layout>
