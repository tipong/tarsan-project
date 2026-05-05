<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Resepsionis')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow">
        <div class="p-4 font-bold text-lg">
            Resepsionis
        </div>

        <nav class="px-4 space-y-2">
            <a href="{{ route('resepsionis.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                Dashboard
            </a>

            <a href="{{ route('resepsionis.orders.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                Orders
            </a>

            <a href="{{ route('resepsionis.orders.walkin.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                Walk-in Booking
            </a>

            <a href="{{ route('resepsionis.availability') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                Availability Kamar
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-left w-full px-3 py-2 text-red-600 hover:bg-gray-100 rounded">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

</body>
</html>
