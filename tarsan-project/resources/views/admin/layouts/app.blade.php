<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tarsan Homestay</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />
    <!-- Assets -->
    @include('layouts.assets')
</head>

<body class="bg-slate-50 font-[Figtree] text-slate-800 antialiased min-h-screen flex selection:bg-indigo-100 selection:text-indigo-900">

    {{-- MOBILE OVERLAY BACKDROP --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    {{-- SIDEBAR --}}
    <aside id="adminSidebar" class="w-64 bg-white border-r border-slate-200 text-slate-900 fixed inset-y-0 left-0 z-50 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow">
        <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
            <a href="{{ Auth::user()->role === 'owner' ? route('admin.dashboard') : route('admin.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-10 object-contain">
                <span class="font-bold text-lg text-slate-900 tracking-tight">{{ Auth::user()->role === 'owner' ? 'Owner' : 'Admin' }}</span>
            </a>
            <button onclick="toggleSidebar()" class="p-2 -mr-2 text-slate-500 hover:text-slate-900 md:hidden focus:outline-none relative z-50 flex items-center justify-center cursor-pointer">
                <svg class="h-6 w-6 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="mt-6 flex-1 space-y-1 px-4">
            <x-admin-link route="admin.dashboard" label="Dashboard" />
            <x-admin-link route="admin.rooms.index" label="Rooms" />
            <x-admin-link route="admin.facilities.index" label="Facilities" />
            <x-admin-link route="admin.users.index" label="Users" />
            <x-admin-link route="admin.vouchers.index" label="Voucher" />
            <x-admin-link route="admin.orders.index" label="Orders" />
            <x-admin-link route="admin.reviews.index" label="Review" />
            
            @if(Auth::user()->role === 'owner')
                <div class="pt-4 pb-2 px-4">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Reports</span>
                </div>
                <x-admin-link route="owner.reports.financial" label="Financial Report" />
            @endif
        </nav>
        
        <div class="p-4 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- NAVBAR --}}
        <header class="bg-white border-b border-slate-200 shadow px-4 md:px-8 py-4 flex justify-between items-center sticky top-0 z-30">
            <div class="flex items-center gap-4">
                {{-- Hamburger menu for mobile --}}
                <button onclick="toggleSidebar()" class="p-2 -ml-2 text-slate-600 hover:text-slate-900 md:hidden focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-semibold text-xl text-slate-800 tracking-tight">
                    @yield('title', 'Dashboard')
                </h1>
            </div>

            <div class="relative" x-data="{ open: false }" id="profileDropdown">
                <button onclick="toggleProfileDropdown()" class="flex items-center gap-3 focus:outline-none group">
                    <img src="{{ image_url(Auth::user()->photo) }}"
                        class="h-9 w-9 rounded-full object-cover ring-2 ring-slate-200 group-hover:ring-indigo-100 transition shadow-sm">
                    <div class="text-left hidden sm:block">
                        <p class="font-bold text-sm text-slate-900 group-hover:text-indigo-600 transition">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ Auth::user()->role }}</p>
                    </div>
                </button>

                {{-- Dropdown Menu --}}
                <div id="dropdownMenu" class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 hidden animate-in fade-in slide-in-from-top-2 duration-200 z-50">
                    <div class="px-4 py-2 border-b border-slate-50 mb-1">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Account Settings</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50 flex items-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m-8 0l-4 4m4 4l4-4"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <script>
                function toggleProfileDropdown() {
                    const menu = document.getElementById('dropdownMenu');
                    menu.classList.toggle('hidden');
                }

                // Close when clicking outside
                window.addEventListener('click', function(e) {
                    const dropdown = document.getElementById('profileDropdown');
                    const menu = document.getElementById('dropdownMenu');
                    if (!dropdown.contains(e.target)) {
                        menu.classList.add('hidden');
                    }
                });
            </script>
        </header>

        {{-- CONTENT --}}
        <main class="p-4 md:p-8 flex-1 overflow-x-hidden overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            const isHidden = overlay.classList.toggle('hidden');
            if (!isHidden) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }
    </script>
</body>
</html>
