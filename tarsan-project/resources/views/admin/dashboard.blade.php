@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Stats Cards --}}
    <div class="grid md:grid-cols-4 gap-6 mb-8">

        {{-- Total Orders --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm">Total Pesanan</p>
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">{{ $totalOrders }}</h2>
            <p class="text-xs text-slate-500 mt-1">Semua pesanan</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm">Total Pendapatan</p>
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <p class="text-xs text-slate-500 mt-1">Sudah dibayar</p>
        </div>

        {{-- Upcoming --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm">Akan Datang</p>
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">{{ $upcomingOrders }}</h2>
            <p class="text-xs text-slate-500 mt-1">Belum check-in</p>
        </div>

        {{-- Ongoing --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
            <div class="flex items-center justify-between mb-2">
                <p class="text-slate-500 text-sm">Sedang Menginap</p>
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">{{ $ongoingOrders }}</h2>
            <p class="text-xs text-slate-500 mt-1">Sedang menginap</p>
        </div>
    </div>

    {{-- Total Rooms --}}
    <div class="grid md:grid-cols-1 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Total Kamar Tersedia</p>
                    <h2 class="text-3xl font-bold text-slate-900">{{ $totalRooms }}</h2>
                </div>
                <svg class="w-12 h-12 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div>
        <h3 class="text-lg font-semibold text-slate-900 mb-4">Aksi Cepat</h3>
        <div class="grid md:grid-cols-4 gap-4">
            <a href="{{ route('admin.orders.index') }}" class="bg-white p-4 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="font-medium text-slate-700">Kelola Pesanan</span>
                </div>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="bg-white p-4 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="font-medium text-slate-700">Kelola Kamar</span>
                </div>
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-white p-4 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium text-slate-700">Kelola Pengguna</span>
                </div>
            </a>
            <a href="{{ route('admin.reports.financial') }}" class="bg-white p-4 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-2m3 2v-2m3 0a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-medium text-slate-700">Laporan Keuangan</span>
                </div>
            </a>
        </div>
    </div>
@endsection
