<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Tarsan Homestay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white shadow-lg hidden md:block">
        <div class="px-6 py-4 border-b">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-10">
                <span class="font-bold text-lg">Admin</span>
            </a>
        </div>

        <nav class="mt-6 space-y-1 px-4">
            <x-admin-link route="admin.dashboard" label="Dashboard" />
            <x-admin-link route="admin.rooms.index" label="Rooms" />
            <x-admin-link route="admin.users.index" label="Users" />
            <x-admin-link route="admin.vouchers.index" label="Voucher" />
            <x-admin-link route="admin.orders.index" label="Orders" />
            <x-admin-link route="admin.reviews.index" label="Review" />

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button class="w-full text-left px-3 py-2 rounded text-red-600 hover:bg-red-50">
                    Logout
                </button>
            </form>
        </nav>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="font-semibold text-xl">
                @yield('title', 'Dashboard')
            </h1>

            <div class="flex items-center gap-3">
                <img
                    src="{{ Auth::user()->photo
                        ? asset('storage/' . Auth::user()->photo)
                        : asset('images/default-avatar.png') }}"
                    class="h-9 w-9 rounded-full object-cover">

                <span class="font-medium">
                    {{ Auth::user()->name }}
                </span>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6 flex-1">
            @yield('content')
        </main>
    </div>

</body>
</html>
