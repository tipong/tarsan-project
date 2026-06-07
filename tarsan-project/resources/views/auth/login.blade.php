<x-guest-layout>
    {{-- Header --}}
    <div class="text-center mb-6">
        <h2 class="text-xl font-black text-slate-900 tracking-tight">Welcome Back</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Please log in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                   placeholder="name@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <label for="login_password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 transition" href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <div class="relative">
                <input id="login_password" type="password" name="password" required autocomplete="current-password"
                       class="w-full bg-slate-50 border-none rounded-2xl pl-5 pr-12 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all text-sm"
                       placeholder="Enter your password">

                <button type="button"
                        onclick="togglePassword('login_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4">
                    <img id="login_eye_icon"
                         src="{{ asset('icons/visibility.png') }}"
                         data-show="{{ asset('icons/visibility.png') }}"
                         data-hide="{{ asset('icons/visibility-off.png') }}"
                         class="h-5 w-5 opacity-40 hover:opacity-75 transition-opacity"
                         alt="Toggle Password">
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" 
                   class="rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer">
            <label for="remember_me" class="ms-2 text-xs font-bold text-slate-500 cursor-pointer">Remember me</label>
        </div>

        {{-- Submit Button --}}
        <div class="pt-2">
            <button type="submit"
                    class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl hover:shadow-xl hover:shadow-indigo-100 transition duration-200 font-bold text-sm">
                Log In
            </button>
        </div>
    </form>

    {{-- Switch Action Button --}}
    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Don't have an account?</p>
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center gap-2 mt-3 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-2xl transition duration-200 w-full sm:w-auto">
            Register Now
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
