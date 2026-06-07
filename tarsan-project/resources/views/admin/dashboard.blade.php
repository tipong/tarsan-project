@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Welcome Hero Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Welcome Back, {{ Auth::user()->name }}!</h1>
            <p class="text-slate-500 text-sm mt-1">Here is a summary of the performance and operations of Tarsan Homestay for today.</p>
        </div>
        <div class="inline-flex items-center gap-2.5 px-4 py-2.5 bg-white rounded-2xl border border-slate-200/80 shadow-sm text-xs font-bold text-slate-600 self-start md:self-auto">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
        {{-- Total Orders --}}
        <div class="bg-white p-4 md:p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-3">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase tracking-wider">Total Orders</p>
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ $totalOrders }}</h2>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Overall Orders</p>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white p-4 md:p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-3">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase tracking-wider">Revenue</p>
                <div class="p-2 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-lg md:text-xl xl:text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Fully Paid</p>
        </div>

        {{-- Upcoming --}}
        <div class="bg-white p-4 md:p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-3">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase tracking-wider">Upcoming</p>
                <div class="p-2 bg-amber-50 rounded-xl text-amber-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ $upcomingOrders }}</h2>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pending Check-in</p>
        </div>

        {{-- Ongoing --}}
        <div class="bg-white p-4 md:p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between mb-3">
                <p class="text-slate-400 text-xs md:text-sm font-bold uppercase tracking-wider">Staying</p>
                <div class="p-2 bg-purple-50 rounded-xl text-purple-600">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ $ongoingOrders }}</h2>
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Staying Guests</p>
        </div>
    </div>

    {{-- Room Banner & Quick Actions Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Total Available Rooms banner --}}
        <div class="bg-slate-950 p-6 md:p-8 rounded-[2rem] text-white relative overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col justify-between min-h-[160px]">
            <div class="absolute -right-6 -bottom-6 opacity-10 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-36 h-36" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="flex items-center justify-between relative z-10">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Total Available Rooms</p>
                    <h2 class="text-4xl font-black mt-2">{{ $totalRooms }}</h2>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                    <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 font-medium z-10">Registered physical homestay room capacity</p>
        </div>

        {{-- Quick Actions --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between h-full">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                        <a href="{{ route('admin.orders.index') }}" class="bg-slate-50 p-3 rounded-2xl hover:bg-indigo-50 border border-transparent hover:border-indigo-100 transition-all duration-300 flex flex-col items-center justify-center text-center group">
                            <div class="w-9 h-9 bg-white shadow-sm rounded-xl flex items-center justify-center shrink-0 text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 text-xs mt-2 group-hover:text-indigo-600 transition-colors">Orders</span>
                        </a>
                        <a href="{{ route('admin.rooms.index') }}" class="bg-slate-50 p-3 rounded-2xl hover:bg-purple-50 border border-transparent hover:border-purple-100 transition-all duration-300 flex flex-col items-center justify-center text-center group">
                            <div class="w-9 h-9 bg-white shadow-sm rounded-xl flex items-center justify-center shrink-0 text-purple-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 text-xs mt-2 group-hover:text-purple-600 transition-colors">Rooms</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="bg-slate-50 p-3 rounded-2xl hover:bg-emerald-50 border border-transparent hover:border-emerald-100 transition-all duration-300 flex flex-col items-center justify-center text-center group">
                            <div class="w-9 h-9 bg-white shadow-sm rounded-xl flex items-center justify-center shrink-0 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 text-xs mt-2 group-hover:text-emerald-600 transition-colors">Users</span>
                        </a>
                        <a href="{{ route('admin.facilities.index') }}" class="bg-slate-50 p-3 rounded-2xl hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all duration-300 flex flex-col items-center justify-center text-center group">
                            <div class="w-9 h-9 bg-white shadow-sm rounded-xl flex items-center justify-center shrink-0 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700 text-xs mt-2 group-hover:text-blue-600 transition-colors">Facilities</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Bookings Live Feed --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6 md:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-base font-black text-slate-900 uppercase tracking-wider">Recent Bookings</h3>
                <p class="text-xs text-slate-400 font-medium mt-0.5">List of the latest 5 transactions received at the homestay</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 transition self-start sm:self-auto">
                View All Orders
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto -mx-6 px-6 sm:mx-0 sm:px-0">
            <table class="w-full text-sm text-left min-w-[700px]">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400">
                        <th class="pb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Guest</th>
                        <th class="pb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                        <th class="pb-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Check In / Out</th>
                        <th class="pb-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Price</th>
                        <th class="pb-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="pb-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8.5 h-8.5 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs shrink-0 shadow-inner">
                                        {{ strtoupper(substr($order->user?->name ?? $order->guest_name ?? 'G', 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-xs sm:text-sm group-hover:text-indigo-600 transition-colors duration-200">{{ $order->user?->name ?? $order->guest_name ?? '-' }}</span>
                                        <span class="text-[9px] text-slate-400 font-mono font-bold mt-0.5 uppercase">#{{ $order->order_code }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                @if($order->items->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($order->items as $item)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                                {{ $item->room?->room_name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="flex items-center gap-1 text-slate-700 font-semibold text-xs">
                                        <span>{{ $order->check_in->format('d M') }}</span>
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                        <span>{{ $order->check_out->format('d M') }}</span>
                                    </div>
                                    <span class="text-[9px] font-medium text-slate-400 mt-1">({{ $order->nights }} Nights)</span>
                                </div>
                            </td>
                            <td class="py-4 text-center text-xs font-black text-slate-800">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 text-center">
                                @if($order->status === 'cancelled')
                                    <span class="inline-flex items-center px-2 py-0.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-full text-[9px] font-black uppercase">Cancelled</span>
                                @elseif($order->checked_out_at)
                                    <span class="inline-flex items-center px-2 py-0.5 bg-slate-50 text-slate-500 border border-slate-200 rounded-full text-[9px] font-black uppercase">Completed</span>
                                @elseif($order->checked_in_at)
                                    <span class="inline-flex items-center px-2 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[9px] font-black uppercase">Checked-in</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[9px] font-black uppercase">Waiting</span>
                                @endif
                            </td>
                            <td class="py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="p-1.5 inline-flex items-center gap-1.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 text-indigo-600 rounded-xl text-[10px] font-bold transition duration-200 border border-slate-200/60 hover:shadow-sm">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 italic text-xs">No recent bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
