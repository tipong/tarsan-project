@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            Reservation
        </h2>

        {{-- ✅ TAMBAH KAMAR LAGI --}}
        <a href="{{ route('tamu.booking.index') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            + Add Another Room
        </a>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        {{-- LEFT --}}
        <div class="md:col-span-2 space-y-4">

            @forelse ($cart as $item)
            <div class="border rounded-lg p-4 mb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-semibold">
                            {{ $item['room_name'] }}
                        </h4>
                        <p class="text-sm text-gray-500">
                            {{ $item['check_in'] }} → {{ $item['check_out'] }}
                            ({{ $item['nights'] }} night)
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold">
                            Rp {{ number_format($item['subtotal']) }}
                        </p>

                        <form method="POST"
                              action="{{ route('tamu.booking.remove', $item['room_id']) }}">
                            @csrf
                            @method('DELETE')

                            <button
                                class="text-sm text-red-500 hover:underline">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
                <p class="text-sm text-gray-500">
                    No room selected yet.
                </p>
            @endforelse

        </div>

        <form method="POST" action="{{ route('tamu.reservation.guest') }}"
            class="bg-white rounded-lg p-6 mb-6">
            @csrf

            <h3 class="font-semibold text-lg mb-4">
                Guest Information
            </h3>

            <div class="space-y-4">

                <div>
                    <label class="text-sm font-medium">Guest Name *</label>
                    <input type="text"
                        name="name"
                        value="{{ session('guest.name') }}"
                        class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium">Phone Number *</label>
                    <input type="text"
                        name="phone"
                        value="{{ session('guest.phone') }}"
                        class="w-full border rounded px-3 py-2"
                        required>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Voucher Code (optional)
                    </label>
                    <input type="text"
                        name="voucher"
                        value="{{ session('voucher.code') }}"
                        class="w-full border rounded px-3 py-2">
                    @error('voucher')
                        <p class="text-sm text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Save Guest Info
                </button>

            </div>
        </form>


        {{-- RIGHT --}}
        @php
            $subtotal = $grandTotal;
            $voucherDiscount = session('voucher.discount', 0);
            $finalTotal = max($subtotal - $voucherDiscount, 0);
        @endphp
        @php
            session([
                'payment' => [
                    'subtotal' => $subtotal,
                    'discount' => $voucherDiscount,
                    'final_total' => $finalTotal,
                ]
            ]);
        @endphp

        <div class="bg-white shadow rounded-lg p-6 h-fit">
            <h3 class="font-semibold mb-4">
                Booking Summary
            </h3>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal) }}</span>
                </div>

                @if($voucherDiscount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Voucher Discount</span>
                    <span>- Rp {{ number_format($voucherDiscount) }}</span>
                </div>
                @endif

                <hr>

                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span class="text-orange-500">
                        Rp {{ number_format($finalTotal) }}
                    </span>
                </div>
            </div>


            @php
                $guestReady = session()->has('guest.name') 
                            && session()->has('guest.phone');
            @endphp

            @if($guestReady)
            <a href="{{ route('tamu.payment.index') }}"
            class="block mt-6 bg-green-600 hover:bg-green-700 text-white py-3 rounded text-center">
                Continue to Payment
            </a>
            @else
            <button disabled
                class="block mt-6 w-full bg-gray-300 text-gray-500 py-3 rounded cursor-not-allowed">
                Fill guest information first
            </button>
            @endif
        </div>

    </div>

</div>
@endsection
