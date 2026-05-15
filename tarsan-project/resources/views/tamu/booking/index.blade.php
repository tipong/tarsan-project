@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header Section --}}
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Book a Room</h1>
            <p class="text-slate-600">Find the perfect room for your dates and needs</p>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 p-6 mb-8">
            <form method="POST" action="{{ route('tamu.booking.search') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    {{-- CHECK IN --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Check In</label>
                        <input type="date"
                               name="check_in"
                               value="{{ request('check_in') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                               required>
                    </div>

                    {{-- CHECK OUT --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Check Out</label>
                        <input type="date"
                               name="check_out"
                               value="{{ request('check_out') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                               required>
                    </div>

                    {{-- SEARCH ROOM NAME --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Room Name</label>
                        <input type="text"
                               name="room_search"
                               placeholder="Search room..."
                               value="{{ request('room_search') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- FACILITIES FILTER --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Facilities</label>
                        <select name="facility" class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                            <option value="">All</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->slug }}" {{ request('facility') == $facility->slug ? 'selected' : '' }}>
                                    {{ $facility->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex gap-2 items-end">
                        <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm">
                            Search
                        </button>
                        <a href="{{ route('tamu.booking.index') }}" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 rounded-2xl hover:bg-gray-300 transition duration-200 font-medium text-sm text-center">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Main Content --}}
        <div class="grid md:grid-cols-4 gap-6">
            {{-- Room List --}}
            <div class="md:col-span-3 space-y-4">
                @forelse($rooms as $room)
                    <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden hover:shadow-md transition {{ isset($room->is_available) && !$room->is_available ? 'opacity-60 pointer-events-none' : '' }}">
                        <div class="md:grid md:grid-cols-4 gap-4 p-5">
                            {{-- Image --}}
                            <div class="relative h-40 md:h-auto bg-gray-50 rounded-2xl overflow-hidden mb-4 md:mb-0 group">
                                @if($room->images->count() > 0)
                                    <img src="{{ asset('storage/' . $room->images->first()->image) }}"
                                         alt="{{ $room->room_name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-500 text-sm">
                                        No image available
                                    </div>
                                @endif

                                {{-- Availability Badge --}}
                                @if(isset($room->is_available))
                                    @if($room->is_available)
                                        <div class="absolute top-3 right-3 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Available
                                        </div>
                                    @else
                                        <div class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Fully Booked
                                        </div>
                                    @endif
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $room->room_name }}</h3>
                                <p class="text-sm text-slate-600 mb-3 line-clamp-2">{{ $room->description }}</p>
                                <div class="flex items-center gap-2 text-sm text-slate-700 mb-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                    <strong>Capacity:</strong> {{ $room->capacity }} guests
                                </div>
                                @if($room->facility_names->isNotEmpty())
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($room->facility_names->slice(0, 2) as $facilityName)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                                {{ $facilityName }}
                                            </span>
                                        @endforeach
                                        @if($room->facility_names->count() > 2)
                                            <span class="px-2 py-1 bg-gray-50 text-slate-600 text-xs rounded-full">
                                                +{{ $room->facility_names->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Action --}}
                            <div class="flex flex-col justify-between">
                                <div>
                                    <p class="text-sm text-slate-500 mb-1">Starting from</p>
                                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($room->price_per_night) }}</p>
                                    <p class="text-xs text-slate-500">/night</p>
                                </div>

                                @php
                                    $hasDate = session()->has('booking_filter');
                                @endphp

                                @if($hasDate)
                                    @if(isset($room->is_available) && $room->is_available)
                                        <form method="POST" action="{{ route('tamu.booking.add') }}" class="mt-4">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <input type="hidden" name="check_in" value="{{ session('booking_filter.check_in') }}">
                                            <input type="hidden" name="check_out" value="{{ session('booking_filter.check_out') }}">
                                            <button type="submit" class="w-full px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm">
                                                + Add
                                            </button>
                                        </form>
                                    @elseif(isset($room->is_available) && !$room->is_available)
                                        <button disabled class="w-full px-4 py-2 bg-red-100 text-red-600 rounded-2xl cursor-not-allowed font-medium text-sm">
                                            Not Available
                                        </button>
                                    @else
                                        <button disabled class="w-full px-4 py-2 bg-slate-100 text-slate-500 rounded-2xl cursor-not-allowed font-medium text-sm">
                                            Select Date
                                        </button>
                                    @endif
                                @else
                                    <button disabled class="w-full px-4 py-2 bg-slate-100 text-slate-500 rounded-2xl cursor-not-allowed font-medium text-sm">
                                        Select Date
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-2xl shadow border border-slate-200 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2 3l2-3m2 3l2-3"></path>
                        </svg>
                        <p class="text-slate-500 text-lg">No rooms available</p>
                        <p class="text-slate-500 text-sm mt-1">Try changing your search filters</p>
                    </div>
                @endforelse
            </div>

            {{-- Sidebar: Reservation Summary --}}
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Booking Summary</h3>

                    @php
                        $cart = session('cart', []);
                        $grandTotal = 0;
                        foreach ($cart as $item) {
                            $grandTotal += $item['subtotal'];
                        }
                    @endphp

                    @if(count($cart))
                        <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                            @foreach($cart as $roomId => $item)
                                <div class="bg-gray-50 p-3 rounded-2xl border border-slate-200">
                                    <p class="font-semibold text-sm text-slate-800">{{ $item['room_name'] }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $item['nights'] }} nights</p>
                                    <p class="text-sm font-semibold text-slate-800 mt-2">Rp {{ number_format($item['subtotal']) }}</p>
                                    <form method="POST" action="{{ route('tamu.booking.remove', $roomId) }}" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 transition">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-200 pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-800">Total</span>
                                <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($grandTotal) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('tamu.reservation.index') }}" class="block w-full px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-center">
                            Continue to Booking
                        </a>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p class="text-sm text-slate-500">No rooms selected yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
