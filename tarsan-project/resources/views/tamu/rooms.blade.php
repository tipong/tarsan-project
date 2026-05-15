@extends('layouts.app')

@section('title', 'Room List')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header Section --}}
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-slate-900">Our Rooms</h1>
                    <p class="text-slate-600 mt-2">Choose the perfect room for your stay</p>
                </div>
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-slate-700 bg-white border border-slate-300 text-slate-900 border-slate-200 rounded-2xl hover:bg-gray-50 transition duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 p-6 mb-8">
            <form method="GET" action="{{ route('kamar.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    {{-- Search --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Search Room</label>
                        <input type="text"
                               name="search"
                               placeholder="Room name..."
                               value="{{ request('search') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Facilities Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Facilities</label>
                        <select name="facility" class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                            <option value="">All Facilities</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->slug }}" {{ request('facility') == $facility->slug ? 'selected' : '' }}>
                                    {{ $facility->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price Min --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Min Price</label>
                        <input type="number"
                               name="price_min"
                               placeholder="0"
                               value="{{ request('price_min') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Price Max --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Max Price</label>
                        <input type="number"
                               name="price_max"
                               placeholder="10000000"
                               value="{{ request('price_max') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Button Group --}}
                    <div class="flex gap-2 items-end">
                        <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm">
                            Filter
                        </button>
                        <a href="{{ route('kamar.index') }}" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 rounded-2xl hover:bg-gray-300 transition duration-200 font-medium text-sm text-center">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Room Grid --}}
        @if($rooms->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-slate-200">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m2 3l2-3m2 3l2-3m2 3l2-3m2 3l2-3"></path>
                </svg>
                <p class="text-slate-500 text-lg">No rooms found</p>
                <p class="text-slate-500 text-sm mt-1">Try changing your search filters</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
                        {{-- Image Container --}}
                        <div class="relative h-48 bg-gray-50 overflow-hidden group">
                            @if($room->images->count() > 0)
                                <img src="{{ asset('storage/' . $room->images->first()->image) }}"
                                     alt="{{ $room->room_name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-100">
                                    <span class="text-slate-500 text-sm">Image not available</span>
                                </div>
                            @endif
                            {{-- Price Badge --}}
                            <div class="absolute top-3 right-3 bg-slate-900 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $room->room_name }}</h3>

                            {{-- Info Grid --}}
                            <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                                <div class="flex items-center gap-2 text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                    <span>{{ $room->capacity }} orang</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                    </svg>
                                    <span>{{ $room->total_rooms }} unit</span>
                                </div>
                            </div>

                            {{-- Facilities --}}
                            @if($room->facility_names->isNotEmpty())
                                <div class="mb-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($room->facility_names->slice(0, 3) as $facilityName)
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full">
                                                {{ $facilityName }}
                                            </span>
                                        @endforeach
                                        @if($room->facility_names->count() > 3)
                                            <span class="px-2 py-1 bg-gray-50 text-slate-600 text-xs rounded-full">
                                                +{{ $room->facility_names->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Description --}}
                            <p class="text-slate-600 text-sm line-clamp-2 mb-4 flex-1">{{ $room->description }}</p>

                            {{-- Actions --}}
                            <div class="flex gap-2">
                                <a href="{{ route('kamar.show', $room) }}"
                                   class="flex-1 px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 text-center font-medium text-sm">
                                    View Details
                                </a>
                                @auth
                                    @if(auth()->user()->role === 'tamu')
                                        <a href="{{ route('tamu.booking.index') }}?room_id={{ $room->id }}"
                                           class="flex-1 px-4 py-2 bg-gray-50 text-slate-900 rounded-2xl hover:bg-slate-100 transition duration-200 text-center font-medium text-sm">
                                            Book
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                       class="flex-1 px-4 py-2 bg-gray-50 text-slate-900 rounded-2xl hover:bg-slate-100 transition duration-200 text-center font-medium text-sm">
                                        Book
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $rooms->links() }}
            </div>
        @endif
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
