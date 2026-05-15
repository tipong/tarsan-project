@extends('layouts.app')

@section('title', $room->room_name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Breadcrumb --}}
        <div class="mb-8 flex items-center gap-2 text-sm text-gray-600">
            <a href="{{ route('kamar.index') }}" class="hover:text-blue-600 transition">Room List</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-800">{{ $room->room_name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Images Section --}}
            <div class="lg:col-span-2">
                {{-- Main Image --}}
                <div class="mb-6 rounded-lg overflow-hidden shadow-lg bg-gray-200">
                    @if($room->images->count() > 0)
                        <img src="{{ asset('storage/' . $room->images->first()->image) }}"
                             alt="{{ $room->room_name }}"
                             class="w-full h-96 object-cover"
                             id="mainImage">
                    @else
                        <div class="w-full h-96 flex items-center justify-center bg-gray-300">
                            <span class="text-gray-500 text-lg">Image not available</span>
                        </div>
                    @endif
                </div>

                {{-- Gallery Thumbnails --}}
                @if($room->images->count() > 1)
                    <div class="grid grid-cols-4 md:grid-cols-5 gap-3">
                        @foreach($room->images as $image)
                            <button
                                onclick="document.getElementById('mainImage').src = '{{ asset('storage/' . $image->image) }}'"
                                class="relative h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-600 transition group">
                                <img src="{{ asset('storage/' . $image->image) }}"
                                     alt="Gallery"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Info Sidebar --}}
            <div class="space-y-6">
                {{-- Title & Price --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $room->room_name }}</h1>
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <p class="text-sm text-gray-600 mb-1">Price Per Night</p>
                        <p class="text-3xl font-bold text-blue-600">
                            Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                {{-- Key Information --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-4">Room Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Kapasitas</p>
                                <p class="font-semibold text-gray-900">{{ $room->capacity }} orang</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Jumlah Unit</p>
                                <p class="font-semibold text-gray-900">{{ $room->total_rooms }} room</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Facilities --}}
                @if($room->facility_names->isNotEmpty())
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="font-bold text-gray-900 mb-4">Fasilitas</h3>
                        <div class="space-y-2">
                            @foreach($room->facility_names as $facilityName)
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $facilityName }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Booking Buttons --}}
                <div class="space-y-3">
                    @auth
                        @if(auth()->user()->role === 'tamu')
                            <a href="{{ route('tamu.booking.index') }}?room_id={{ $room->id }}"
                               class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-semibold text-center block">
                                Book This Room
                            </a>
                        @else
                            <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm text-red-700">Only guests can book rooms</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 font-semibold text-center block">
                            Login to Book
                        </a>
                    @endauth

                    <a href="{{ route('kamar.index') }}"
                       class="w-full px-6 py-3 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 transition duration-200 font-semibold text-center block">
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Description --}}
        <div class="mt-12 bg-white p-8 rounded-lg shadow-sm border border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
            <p class="text-gray-700 leading-relaxed">{{ $room->description }}</p>
        </div>
    </div>
</div>
@endsection
