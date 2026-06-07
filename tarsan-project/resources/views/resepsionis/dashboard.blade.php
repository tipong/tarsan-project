@extends('resepsionis.layouts.app')

@section('title', 'Receptionist Dashboard')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Receptionist Dashboard</h1>
            <p class="text-slate-600 mt-1">Manage orders and room availability</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            {{-- Upcoming Check-in --}}
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-slate-500 text-xs md:text-sm font-medium">Upcoming</p>
                    <div class="p-2 bg-blue-50 rounded-xl text-blue-500">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">{{ $upcoming }}</h2>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Not checked-in</p>
            </div>

            {{-- Ongoing Stay --}}
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-slate-500 text-xs md:text-sm font-medium">Currently Staying</p>
                    <div class="p-2 bg-purple-50 rounded-xl text-purple-500">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">{{ $ongoing }}</h2>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Currently staying</p>
            </div>

            {{-- Today Check-in --}}
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-slate-500 text-xs md:text-sm font-medium">Today Check-in</p>
                    <div class="p-2 bg-emerald-50 rounded-xl text-emerald-500">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m8 0l4 4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">{{ $todayCheckin }}</h2>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Check-in scheduled</p>
            </div>

            {{-- Today Check-out --}}
            <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-slate-500 text-xs md:text-sm font-medium">Today Check-out</p>
                    <div class="p-2 bg-amber-50 rounded-xl text-amber-500">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m-8 0l-4 4m4 4l4-4"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">{{ $todayCheckout }}</h2>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mt-1">Check-out scheduled</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h3 class="text-base font-bold text-slate-800 uppercase tracking-widest mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('resepsionis.orders.index') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-indigo-100 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-indigo-100 transition-colors">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-700 group-hover:text-indigo-600 transition-colors">Manage Orders</span>
                    </div>
                </a>

                <a href="{{ route('resepsionis.orders.walkin.create') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-emerald-100 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-700 group-hover:text-emerald-600 transition-colors">Walk-in Booking</span>
                    </div>
                </a>

                <a href="{{ route('resepsionis.availability') }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-purple-100 transition-all duration-300 hover:scale-[1.02] hover:-translate-y-0.5 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-purple-100 transition-colors">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-slate-700 group-hover:text-purple-600 transition-colors">Check Availability</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
