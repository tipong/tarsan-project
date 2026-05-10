<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Ubah Password
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        {{-- PASSWORD SAAT INI --}}
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
            <div class="relative">
                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition pr-12"
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

        {{-- PASSWORD BARU --}}
        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <div class="relative">
                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition pr-12"
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

        {{-- KONFIRMASI PASSWORD --}}
        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <div class="relative">
                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition pr-12"
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

        {{-- SIMPAN --}}
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-medium text-sm">
                Ubah Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>
