<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Title --}}
    <title>Tarsan Homestay</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('tarsanhomestay.png') }}">
    {{-- atau jika pakai ico --}}
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}"> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <body class="font-[Figtree] text-slate-800 antialiased selection:bg-slate-200 selection:text-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50">
            <div>
                <a href="/">
                    <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-16 object-contain hover:scale-105 transition-transform" alt="Logo">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-2xl border border-slate-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
