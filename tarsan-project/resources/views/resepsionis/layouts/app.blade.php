<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Resepsionis') - Tarsan Homestay</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 font-[Figtree] text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border border-slate-300 text-slate-900-r border-slate-200 hidden md:flex flex-col shadow">
        <div class="px-6 py-5 border-b border-slate-200">
            <a href="{{ route('resepsionis.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-10 object-contain">
                <span class="font-bold text-lg text-slate-900 tracking-tight">Resepsionis</span>
            </a>
        </div>

        <nav class="mt-6 flex-1 space-y-1 px-4">
            <a href="{{ route('resepsionis.dashboard') }}"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resepsionis.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="inline-block w-5 h-5 mr-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('resepsionis.orders.index') }}"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resepsionis.orders.*') && !request()->routeIs('resepsionis.orders.walkin.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="inline-block w-5 h-5 mr-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Orders
            </a>

            <a href="{{ route('resepsionis.orders.walkin.create') }}"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resepsionis.orders.walkin.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="inline-block w-5 h-5 mr-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Walk-in Booking
            </a>

            <a href="{{ route('resepsionis.availability') }}"
               class="block px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('resepsionis.availability*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <svg class="inline-block w-5 h-5 mr-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Availability Kamar
            </a>
        </nav>

        <div class="p-4 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                    <svg class="inline-block w-5 h-5 mr-2 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m-8 0l-4 4m4 4l4-4"></path>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- NAVBAR --}}
        <header class="bg-white border border-slate-300 text-slate-900-b border-slate-200 shadow px-8 py-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="font-semibold text-xl text-slate-800 tracking-tight">
                @yield('title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-3">
                <span class="font-medium text-sm text-slate-700">
                    {{ Auth::user()->name }}
                </span>
                <img
                    src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/default-avatar.png') }}"
                    class="h-9 w-9 rounded-full object-cover ring-2 ring-slate-200">
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-8 overflow-x-hidden overflow-y-auto">
            @yield('content')
        </main>
    </div>

</div>

{{-- SweetAlert Notifications --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#4f46e5',
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#ef4444'
    });
</script>
@endif

@yield('scripts')

</body>
</html>
