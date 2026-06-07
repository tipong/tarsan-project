@extends('resepsionis.layouts.app')

@section('title', 'Room Availability')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('resepsionis.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-200 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Check Room Availability</h1>
            <p class="text-slate-600 mt-1">Select a date to see available rooms</p>
        </div>

        {{-- Filter Form --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-8">
            <form method="POST" action="{{ route('resepsionis.availability.check') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Check-in --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Check-in Date</label>
                        <input type="date" name="check_in" required
                               value="{{ $checkIn ?? date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Check-out --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Check-out Date</label>
                        <input type="date" name="check_out" required
                               value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Button --}}
                    <div class="md:col-span-2 flex gap-3">
                        <button type="submit" class="flex-1 px-6 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium">
                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Check Availability
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results --}}
        @if(isset($rooms))
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-5 md:px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-base md:text-lg font-semibold text-slate-900">
                    Search Results
                    <span class="text-sm font-normal text-slate-500 ml-1">
                        ({{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('d M Y') : '-' }} - {{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('d M Y') : '-' }})
                    </span>
                </h3>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50/70 border-b border-slate-200/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Price/Night</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rooms as $data)
                        <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                            <td class="px-6 py-4.5">
                                <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors duration-200">{{ $data['room']->room_name ?? '-' }}</p>
                                <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 font-semibold mt-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Capacity: {{ $data['room']->capacity ?? '-' }} people
                                </span>
                            </td>
                            <td class="px-6 py-4.5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-850 text-sm">Rp {{ number_format($data['room']->price_per_night ?? 0, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">/ night</span>
                                </div>
                            </td>
                            <td class="px-6 py-4.5 text-center">
                                @if($data['available'])
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Available
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Occupied
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4.5 text-center">
                                @if($data['available'])
                                    <a href="{{ route('resepsionis.orders.walkin.create', [
                                        'room_id' => $data['room']->id,
                                        'check_in' => $checkIn,
                                        'check_out' => $checkOut
                                    ]) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-sm hover:shadow transition duration-200 font-bold text-xs uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Booking
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs font-medium">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">
                                No rooms found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-slate-100">
                @forelse($rooms as $data)
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="font-bold text-slate-900">{{ $data['room']->room_name ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Capacity: {{ $data['room']->capacity ?? '-' }} people</p>
                                <p class="text-sm font-bold text-indigo-600 mt-0.5">Rp {{ number_format($data['room']->price_per_night ?? 0, 0, ',', '.') }}<span class="text-slate-400 font-normal text-xs">/night</span></p>
                            </div>
                            @if($data['available'])
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 shrink-0">
                                    ✓ Available
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 shrink-0">
                                    ✗ Occupied
                                </span>
                            @endif
                        </div>
                        @if($data['available'])
                             <a href="{{ route('resepsionis.orders.walkin.create', [
                                'room_id' => $data['room']->id,
                                'check_in' => $checkIn,
                                'check_out' => $checkOut
                            ]) }}"
                               class="w-full flex items-center justify-center gap-2 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition font-bold text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Book Now
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="px-5 py-10 text-center">
                        <p class="text-slate-500 text-sm">No rooms found.</p>
                    </div>
                @endforelse
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
