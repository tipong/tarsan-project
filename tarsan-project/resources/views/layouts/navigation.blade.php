<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
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
            <div class="hidden sm:flex sm:items-center sm:ms-6">
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
