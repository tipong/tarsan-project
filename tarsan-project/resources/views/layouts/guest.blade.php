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
    {{-- or use ico if needed --}}
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}"> --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <!-- Assets -->
    @include('layouts.assets')
</head>

<body class="font-[Figtree] text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900 min-h-screen bg-gradient-to-br from-indigo-50/40 via-white to-slate-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md py-6">
        <div class="flex justify-between items-center mb-6 px-4">
            <a href="/" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-indigo-600 transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Home
            </a>
            <a href="/">
                <img src="{{ asset('images/tarsanhomestay.png') }}" class="h-8 object-contain hover:scale-105 transition duration-300" alt="Logo">
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 p-8 md:p-10">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
