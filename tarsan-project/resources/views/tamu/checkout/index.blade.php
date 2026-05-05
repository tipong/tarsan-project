<x-app-layout>

<div class="max-w-5xl mx-auto mt-10 px-4">

    {{-- PAGE TITLE --}}
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-800">
            Checkout Confirmation
        </h2>
        <p class="text-gray-500">
            Please review your booking details before confirming.
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        {{-- LEFT : BOOKING DETAIL --}}
        <div class="md:col-span-2 bg-white shadow rounded-lg p-6 space-y-6">

            {{-- ROOM INFO --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-800">
                {{ $order->items[0]->room->room_name }}
                </h3>
                <p class="text-sm text-gray-500">
                    Capacity: {{ $room->capacity }} Persons
                </p>
            </div>

            <hr>

            {{-- DATE INFO --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Check In</p>
                    <p class="font-semibold">{{ $order->check_in->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Check Out</p>
                    <p class="font-semibold">{{ $order->check_out->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Nights</p>
                    <p class="font-semibold">{{ $order->nights }}</p>
                </div>

                <div>
                    <p class="text-gray-500">Guests</p>
                    <p class="font-semibold">{{ $guests }} Person(s)</p>
                </div>
            </div>

            <hr>

            {{-- GUEST INFO --}}
            <div>
                <h4 class="font-semibold mb-2">Guest Information</h4>
                <p class="text-sm text-gray-600">
                    Name: <strong>{{ auth()->user()->name }}</strong><br>
                    Email: <strong>{{ auth()->user()->email }}</strong>
                </p>
            </div>

        </div>

        {{-- RIGHT : PRICE SUMMARY --}}
        <div class="bg-white shadow rounded-lg p-6 h-fit">

            <h3 class="font-semibold text-lg mb-4">
                Price Summary
            </h3>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Room Price</span>
                    <span>Rp {{ number_format($room->price_per_night) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Nights</span>
                    <span>{{ $nights }}</span>
                </div>

                <hr>

                <div class="flex justify-between text-lg font-bold text-orange-500">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->total_price) }}</span>
                </div>
            </div>

            {{-- CONFIRM BUTTON --}}
            <form method="POST"
                  action="{{ route('tamu.checkout.confirm') }}"
                  class="mt-6">
                @csrf

                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="check_in" value="{{ $check_in }}">
                <input type="hidden" name="check_out" value="{{ $check_out }}">
                <input type="hidden" name="guests" value="{{ $guests }}">
                <input type="hidden" name="total" value="{{ $total }}">

                <button
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded font-semibold transition">
                    Confirm Booking
                </button>
            </form>

            <a href="{{ route('tamu.booking.index') }}"
               class="block text-center text-sm text-gray-500 mt-4 hover:underline">
                ← Back to Booking
            </a>

        </div>

    </div>
</div>

</x-app-layout>
