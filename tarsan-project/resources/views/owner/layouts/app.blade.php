<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Tarsan Homestay</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />
    <!-- Assets -->
    @include('layouts.assets')
</head>

<body class="bg-slate-50 font-[Figtree] text-slate-800 antialiased min-h-screen flex selection:bg-indigo-100 selection:text-indigo-900">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border border-slate-300 text-slate-900 border-slate-200 hidden md:flex flex-col shadow">
        <div class="px-6 py-5 border-b border-slate-200">
            <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-10 object-contain">
                <span class="font-bold text-lg text-slate-900 tracking-tight">Owner</span>
            </a>
        </div>

        <nav class="mt-6 flex-1 space-y-1 px-4">
            <x-admin-link route="owner.dashboard" label="Dashboard" />
            <x-admin-link route="owner.reports.financial" label="Financial Report" />
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
        <header class="bg-white border border-slate-300 text-slate-900-b border-slate-200 shadow px-8 py-4 flex justify-between items-center sticky top-0 z-10">
            <h1 class="font-semibold text-xl text-slate-800 tracking-tight">
                @yield('title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-3">
                <img
                    src="{{ image_url(Auth::user()->photo) }}"
                    class="h-9 w-9 rounded-full object-cover ring-2 ring-slate-200">

                <span class="font-medium text-sm text-slate-700">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-8 flex-1 overflow-x-hidden overflow-y-auto">
            @yield('content')
        </main>
    </div>

    @yield('scripts')

</body>
</html>
