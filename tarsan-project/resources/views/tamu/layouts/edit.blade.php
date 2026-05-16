<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tarsan Homestay</title>

    <!-- Assets -->
    @include('layouts.assets')
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- NAVBAR --}}
    @include('layouts.navigation')

    {{-- HEADER KHUSUS EDIT --}}
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-6 flex items-center gap-4">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- CONTENT --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

</body>
</html>
