<nav x-data="{ mobileMenuOpen: false }" class="bg-white/90 backdrop-blur-md shadow sticky top-0 z-50 transition-all border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        {{-- LOGO --}}
        <a href="{{ route('tamu.dashboard') }}" class="flex items-center gap-3 transition-transform hover:scale-105">
            <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-14 object-contain" alt="Logo">
            <span class="font-[Playfair_Display] font-bold text-xl tracking-tight text-slate-900">Tarsan Homestay</span>
        </a>

        {{-- MENU (DESKTOP) --}}
        <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
            <a href="{{ route('tamu.dashboard') }}" class="text-slate-600 hover:text-slate-900 transition-colors {{ request()->routeIs('tamu.dashboard') ? 'text-indigo-600 font-bold' : '' }}">Home</a>
            <a href="{{ route('tamu.dashboard') }}#tentang" class="block text-slate-600 hover:text-slate-900">About</a>
            <a href="{{ route('tamu.dashboard') }}#fasilitas" class="block text-slate-600 hover:text-slate-900">Facilities</a>
            <a href="{{ route('kamar.index') }}" class="text-slate-600 hover:text-slate-900 transition-colors {{ request()->routeIs('kamar.index') ? 'text-indigo-600 font-bold' : '' }}">Rooms</a>
            @auth
                <!-- <a href="{{ route('tamu.orders') }}" class="text-slate-600 hover:text-slate-900 transition-colors {{ request()->routeIs('tamu.orders') ? 'text-indigo-600 font-bold' : '' }}">My Order</a> -->
            @endauth
        </div>

        {{-- AUTH AREA & MOBILE TOGGLE --}}
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-slate-900 text-white text-sm font-medium rounded-full hover:bg-slate-800 transition-colors shadow-md">Register</a>
                @endguest

                @auth
                    <a href="{{ route('tamu.notifications.index') }}" class="relative text-slate-600 hover:text-slate-900 transition-colors mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="notif-badge-nav" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center hidden"></span>
                    </a>
                    
                    <div class="group relative inline-block">
                        <button class="flex items-center gap-3 focus:outline-none bg-gray-50 hover:bg-slate-100 px-2 py-1.5 rounded-full transition border border-slate-200">
                            <img src="{{ image_url(Auth::user()->photo) }}" class="h-8 w-8 rounded-full object-cover shadow">
                            <span class="font-medium text-sm text-slate-700 pr-2">{{ auth()->user()->name }}</span>
                        </button>
                        <div class="absolute right-0 mt-3 w-48 bg-white border border-slate-200 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-gray-50 rounded-t-xl">Edit Profile</a>
                            <a href="{{ route('tamu.orders') }}" class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-gray-50">My Order</a>
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- MOBILE TOGGLE --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="sm:hidden p-2 text-slate-600 hover:text-slate-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- MOBILE MENU --}}
        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
             class="md:hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-xl py-4 px-6 space-y-4 animate-in fade-in slide-in-from-top-2">
            <a href="{{ route('tamu.dashboard') }}" class="block text-slate-600 hover:text-slate-900 {{ request()->routeIs('tamu.dashboard') ? 'text-indigo-600 font-bold' : '' }}">Home</a>
            <a href="{{ route('tamu.dashboard') }}#tentang" class="block text-slate-600 hover:text-slate-900">About</a>
            <a href="{{ route('tamu.dashboard') }}#fasilitas" class="block text-slate-600 hover:text-slate-900">Facilities</a>
            <a href="{{ route('kamar.index') }}" class="block text-slate-600 hover:text-slate-900 {{ request()->routeIs('kamar.index') ? 'text-indigo-600 font-bold' : '' }}">Rooms</a>
            @auth
                <!-- <a href="{{ route('tamu.orders') }}" class="block text-slate-600 hover:text-slate-900 {{ request()->routeIs('tamu.orders') ? 'text-indigo-600 font-bold' : '' }}">My Order</a> -->
                <div class="h-px bg-slate-100 my-2"></div>
                <a href="{{ route('profile.edit') }}" class="block text-slate-600 hover:text-slate-900">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-red-600 hover:text-red-700">Logout</button>
                </form>
            @else
                <div class="h-px bg-slate-100 my-2"></div>
                <a href="{{ route('login') }}" class="block text-slate-600">Login</a>
                <a href="{{ route('register') }}" class="block text-slate-900 font-bold">Register</a>
            @endguest
        </div>
    </div>
</nav>
