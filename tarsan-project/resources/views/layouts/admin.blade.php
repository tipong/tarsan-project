<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tarsan Homestay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-white shadow-md">
        <div class="p-4 text-xl font-bold border-b">
            Admin Panel
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-200">
                Dashboard
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-200">
                Manage Rooms
            </a>
            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                 @csrf
            <button type="submit"
                    class="w-full text-left px-3 py-2 rounded text-red-600 hover:bg-red-100">
                Logout
            </button>
             </form>
        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
