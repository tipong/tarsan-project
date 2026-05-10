<nav x-data="{ open: false }" class="bg-white border border-slate-300 text-slate-900-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LEFT : LOGO --}}
            <a href="{{ route('tamu.dashboard') }}" class="flex items-center gap-3">
                <img
                    src="{{ asset('images/tarsanhomestay.png') }}"
                    class="h-14 w-auto"
                    alt="Tarsan Homestay">

                <span class="font-bold text-lg text-gray-800">
                    Tarsan Homestay
                </span>
            </a>


            {{-- RIGHT : PROFILE --}}
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{-- Notifikasi --}}
                <a href="{{ route('tamu.notifications.index') }}" class="relative text-gray-400 hover:text-gray-600 transition-colors mr-4 flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <span id="notif-badge-nav" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center hidden"></span>
                </a>

                <x-dropdown align="right" width="48">

                    {{-- Trigger --}}
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2
                                   border border-transparent text-sm font-medium
                                   rounded-md text-gray-600 bg-white
                                   hover:text-gray-800 focus:outline-none">

                            {{-- FOTO --}}
                            <img
                                src="{{ Auth::user()->photo
                                    ? asset('storage/' . Auth::user()->photo)
                                    : asset('images/default-avatar.png') }}"
                                class="h-8 w-8 rounded-full object-cover border">

                            <span>{{ Auth::user()->name }}</span>

                            <svg class="fill-current h-4 w-4"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586
                                         l3.293-3.293a1 1 0 111.414 1.414l-4 4
                                         a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    {{-- Dropdown --}}
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Edit Profile
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('tamu.dashboard')">
                            Dashboard
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            {{-- GUEST LOGIN LINKS --}}
            @guest
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
                <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Login
                </a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Register
                </a>
            </div>
            @endguest

            {{-- MOBILE --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2
                               rounded-md text-gray-400 hover:text-gray-500
                               hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none"
                         viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
