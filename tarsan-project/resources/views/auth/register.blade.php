<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-6">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Create Account</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Create an account to book your stay</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                   placeholder="Full Name">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                   placeholder="name@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Password</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full bg-slate-50 border-none rounded-2xl pl-5 pr-12 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                       placeholder="Create password">

                <button type="button"
                        onclick="togglePassword('password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4">
                    <img src="{{ asset('icons/visibility.png') }}"
                         data-show="{{ asset('icons/visibility.png') }}"
                         data-hide="{{ asset('icons/visibility-off.png') }}"
                         class="h-5 w-5 opacity-40 hover:opacity-75 transition-opacity"
                         alt="Toggle Password">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Confirm Password</label>
            <div class="relative">
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full bg-slate-50 border-none rounded-2xl pl-5 pr-12 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                       placeholder="Confirm password">

                <button type="button"
                        onclick="togglePassword('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4">
                    <img src="{{ asset('icons/visibility.png') }}"
                         data-show="{{ asset('icons/visibility.png') }}"
                         data-hide="{{ asset('icons/visibility-off.png') }}"
                         class="h-5 w-5 opacity-40 hover:opacity-75 transition-opacity"
                         alt="Toggle Password">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl hover:shadow-xl hover:shadow-indigo-100 transition duration-200 font-bold text-sm">
                Register
            </button>
        </div>
    </form>

    {{-- Switch Action Button --}}
    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Already have an account?</p>
        <a href="{{ route('login') }}"
           class="inline-flex items-center justify-center gap-2 mt-3 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-2xl transition duration-200 w-full sm:w-auto">
            Log In Here
        </a>
    </div>

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
