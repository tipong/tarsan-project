@extends('layouts.app')

@section('content')

{{-- ================= FILTER ================= --}}
<form method="POST"
      action="{{ route('tamu.booking.search') }}"
      class="bg-white shadow rounded-lg max-w-7xl mx-auto mt-8 p-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

        {{-- CHECK IN --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Check In
            </label>
            <input type="date"
                   name="check_in"
                   value="{{ request('check_in') }}"
                   class="border rounded-md px-3 py-2 w-full h-[44px]"
                   required>
        </div>

        {{-- CHECK OUT --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Check Out
            </label>
            <input type="date"
                   name="check_out"
                   value="{{ request('check_out') }}"
                   class="border rounded-md px-3 py-2 w-full h-[44px]"
                   required>
        </div>

        {{-- BUTTON --}}
        <div class="md:col-span-3">
            <button type="submit"
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-md h-[44px] transition">
                Check Availability
            </button>
        </div>

    </div>
</form>


{{-- ================= MAIN CONTENT ================= --}}
<div class="max-w-7xl mx-auto px-6 py-10 grid md:grid-cols-4 gap-6">

    {{-- ================= ROOM LIST ================= --}}
    <div class="md:col-span-3 space-y-6">

        @forelse($rooms as $room)
        <div class="bg-white rounded shadow p-6 grid md:grid-cols-4 gap-6">

            {{-- IMAGE --}}
            <div
                x-data="{
                    index: 0,
                    images: {{ $room->images->pluck('image')->toJson() }}
                }"
                class="relative w-full h-48 overflow-hidden rounded bg-gray-100"
            >

                <template x-for="(img, i) in images" :key="i">
                    <img x-show="index === i"
                         x-transition
                         :src="'{{ asset('storage') }}/' + img"
                         class="absolute inset-0 w-full h-full object-cover">
                </template>

                <button x-show="images.length > 1"
                        @click="index = (index - 1 + images.length) % images.length"
                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full w-8 h-8">
                    ‹
                </button>

                <button x-show="images.length > 1"
                        @click="index = (index + 1) % images.length"
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full w-8 h-8">
                    ›
                </button>
            </div>

            {{-- INFO --}}
            <div class="md:col-span-2">
                <h3 class="text-xl font-semibold">{{ $room->room_name }}</h3>

                <p class="text-sm text-gray-500">
                    👥 {{ $room->capacity }} Person
                </p>

                <p class="mt-2 text-gray-600 line-clamp-3">
                    {{ $room->description }}
                </p>

                <div class="mt-2 text-sm text-gray-500">
                    Facilities: {{ $room->facilities }}
                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex flex-col justify-between">
                <div>
                    <p class="text-sm text-gray-500">Start From</p>
                    <p class="text-2xl font-bold text-orange-500">
                        Rp {{ number_format($room->price_per_night) }}
                    </p>
                    <p class="text-xs text-gray-400">per night</p>
                </div>

                <div class="space-y-2">
                    {{-- VIEW DETAIL (TIDAK DIHAPUS) --}}
                    <a href="{{ route('tamu.rooms') }}"
                       class="block w-full border rounded py-2 text-center hover:bg-gray-100">
                        View Detail
                    </a>

                    {{-- ADD ROOM --}}
                    @php
                        $hasDate = session()->has('booking_filter');
                    @endphp

                    @if($hasDate)
                    <form method="POST" action="{{ route('tamu.booking.add') }}">
                        @csrf

                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="check_in" value="{{ session('booking_filter.check_in') }}">
                        <input type="hidden" name="check_out" value="{{ session('booking_filter.check_out') }}">

                        <button
                            type="submit"
                            class="w-full bg-blue-600 text-white rounded py-2 hover:bg-blue-700">
                            Add Room +
                        </button>
                    </form>
                    @else
                    <button
                        disabled
                        class="w-full bg-gray-300 text-gray-500 rounded py-2 cursor-not-allowed">
                        Select date first
                    </button>
                    @endif


                </div>
            </div>

        </div>
        @empty
            <p class="text-center text-gray-500">
                No rooms available for selected date
            </p>
        @endforelse

    </div>


    {{-- ================= CART / RESERVATION SUMMARY ================= --}}
    <div class="bg-white shadow rounded-lg p-4 h-fit sticky top-24">

        <h3 class="font-semibold text-lg mb-4">
            Reservation Summary
        </h3>

        @php
            $cart = session('cart', []);
            $grandTotal = 0;

            foreach ($cart as $item) {
                $grandTotal += $item['subtotal'];
            }
        @endphp

        @if(count($cart))
        @foreach($cart as $roomId => $item)

        <div class="flex justify-between items-start border-b pb-4 mb-4">
            <div>
                <p class="font-semibold">{{ $item['room_name'] }}</p>
                <p class="text-sm text-gray-500">
                    {{ $item['check_in'] }} → {{ $item['check_out'] }}
                </p>
                <p class="text-sm">
                    Rp {{ number_format($item['subtotal']) }}
                </p>
            </div>

            <form method="POST"
                action="{{ route('tamu.booking.remove', $roomId) }}">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-red-500 text-sm hover:underline">
                    Remove
                </button>
            </form>
        </div>

        @endforeach

        @else
            <p class="text-sm text-gray-500">
                No room selected yet
            </p>
        @endif


        <hr class="my-3">

        <div class="flex justify-between font-semibold">
            <span>Total</span>
            <span>Rp {{ number_format($grandTotal) }}</span>
        </div>

        <a href="{{ route('tamu.reservation.index') }}"
            class="block mt-4 bg-green-600 text-white text-center py-2 rounded">
                Continue to Reservation
        </a>

    </div>

</div>

@endsection