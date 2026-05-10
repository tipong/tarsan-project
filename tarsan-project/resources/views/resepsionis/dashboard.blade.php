@extends('resepsionis.layouts.app')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Dashboard Resepsionis</h1>
            <p class="text-slate-600 mt-1">Kelola pesanan dan ketersediaan kamar</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Upcoming Check-in --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm text-slate-500">Akan Datang</p>
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $upcoming }}</p>
                <p class="text-xs text-slate-500 mt-1">Belum check-in</p>
            </div>

            {{-- Ongoing Stay --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm text-slate-500">Sedang Menginap</p>
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $ongoing }}</p>
                <p class="text-xs text-slate-500 mt-1">Sedang menginap</p>
            </div>

            {{-- Today Check-in --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm text-slate-500">Check-in Hari Ini</p>
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m8 0l4 4m-4 4l-4-4"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $todayCheckin }}</p>
                <p class="text-xs text-slate-500 mt-1">Jadwal check-in</p>
            </div>

            {{-- Today Check-out --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-sm text-slate-500">Check-out Hari Ini</p>
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m-8 0l-4 4m4 4l4-4"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-slate-900">{{ $todayCheckout }}</p>
                <p class="text-xs text-slate-500 mt-1">Jadwal check-out</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('resepsionis.orders.index') }}" class="bg-white p-5 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-700">Kelola Pesanan</span>
                    </div>
                </a>

                <a href="{{ route('resepsionis.orders.walkin.create') }}" class="bg-white p-5 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-700">Walk-in Booking</span>
                    </div>
                </a>

                <a href="{{ route('resepsionis.availability') }}" class="bg-white p-5 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-medium text-slate-700">Cek Ketersediaan</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
