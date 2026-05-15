@extends('resepsionis.layouts.app')

@section('title', 'Walk-in Booking')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('resepsionis.orders.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-200 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Order List
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Walk-in Booking</h1>
            <p class="text-slate-600 mt-1">Create a new booking for walk-in guests</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('resepsionis.orders.walkin.store') }}" id="walkinForm" class="space-y-6">
            @csrf

            {{-- Guest Information --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Guest Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Guest Name <span class="text-red-500">*</span></label>
                        <input type="text"
                               name="guest_name"
                               placeholder="Enter guest full name"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel"
                               name="guest_phone"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                               required>
                    </div>
                </div>
            </div>

            {{-- Room & Dates --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Room Information
                </h3>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Select Room (Can select multiple) <span class="text-red-500">*</span></label>
                    <div class="space-y-2 max-h-60 overflow-y-auto p-4 border border-slate-200 rounded-2xl">
                        @foreach($rooms as $room)
                            <label class="flex items-center p-3 rounded-xl hover:bg-slate-50 cursor-pointer transition border border-transparent hover:border-slate-100">
                                <input type="checkbox" name="room_ids[]" value="{{ $room->id }}" data-price="{{ $room->price_per_night }}" class="room-checkbox mr-3 h-5 w-5 text-indigo-600 rounded-md border-slate-300 focus:ring-indigo-500">
                                <div class="flex-1">
                                    <div class="text-sm font-bold text-slate-800">{{ $room->room_name }}</div>
                                    <div class="text-xs text-slate-500">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}/malam — Kapasitas: {{ $room->capacity }} org</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Check-in Date <span class="text-red-500">*</span></label>
                        <input type="date" name="check_in_date" id="checkInDate" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Check-out Date <span class="text-red-500">*</span></label>
                        <input type="date" name="check_out_date" id="checkOutDate" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-indigo-900 text-white p-6 rounded-2xl shadow-xl mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Estimated Total Price</p>
                        <h2 class="text-3xl font-black" id="displayTotalPrice">Rp 0</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Duration</p>
                        <h2 class="text-xl font-bold" id="displayNights">1 Night</h2>
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Payment Method
                </h3>

                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition border-2 hover:border-indigo-600">
                        <input type="radio" name="payment_method" value="cash" class="mr-3 text-indigo-600 focus:ring-indigo-600 h-5 w-5" checked>
                        <div class="flex-1">
                            <span class="text-slate-800 font-bold">💵 Cash</span>
                            <p class="text-xs text-slate-500">Guest pays directly at reception</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition border-2 hover:border-indigo-600">
                        <input type="radio" name="payment_method" value="bank_transfer" class="mr-3 text-indigo-600 focus:ring-indigo-600 h-5 w-5">
                        <div class="flex-1">
                            <span class="text-slate-800 font-bold">🏦 Bank Transfer</span>
                            <p class="text-xs text-slate-500">Guest performs manual transfer</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-4">
                <a href="{{ route('resepsionis.orders.index') }}"
                   class="flex-1 px-6 py-4 bg-slate-100 text-slate-700 rounded-2xl hover:bg-slate-200 transition duration-200 font-bold text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-[2] px-6 py-4 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition duration-200 font-bold shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save & Check-in Now
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Form validation before submit
    document.getElementById('walkinForm').addEventListener('submit', function(e) {
        const roomCheckboxes = document.querySelectorAll('.room-checkbox:checked');
        const checkInDate = document.getElementById('checkInDate').value;
        const checkOutDate = document.getElementById('checkOutDate').value;
        const guestName = document.querySelector('input[name="guest_name"]').value;
        const guestPhone = document.querySelector('input[name="guest_phone"]').value;

        // Validate data
        if (!guestName.trim()) {
            e.preventDefault();
            alert('Guest name must be filled');
            return false;
        }

        if (!guestPhone.trim()) {
            e.preventDefault();
            alert('Nomor telepon harus diisi');
            return false;
        }

        if (roomCheckboxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one room');
            return false;
        }

        if (!checkInDate || !checkOutDate) {
            e.preventDefault();
            alert('Tanggal check-in dan check-out harus diisi');
            return false;
        }

        const checkIn = new Date(checkInDate);
        const checkOut = new Date(checkOutDate);

        if (checkOut <= checkIn) {
            e.preventDefault();
            alert('Check-out date must be greater than check-in date');
            return false;
        }

        // If all validations pass, submit form
        return true;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.room-checkbox');
        const checkInInput = document.getElementById('checkInDate');
        const checkOutInput = document.getElementById('checkOutDate');
        const displayTotal = document.getElementById('displayTotalPrice');
        const displayNights = document.getElementById('displayNights');

        function calculateTotal() {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);

            let nights = 0;
            if (checkIn && checkOut && checkOut > checkIn) {
                const diffTime = Math.abs(checkOut - checkIn);
                nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            } else if (checkIn && checkOut && checkOut.getTime() === checkIn.getTime()) {
                nights = 1;
            }

            if (nights <= 0) nights = 1;
            displayNights.innerText = nights + ' Malam';

            let totalPerNight = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    totalPerNight += parseInt(cb.dataset.price);
                }
            });

            const grandTotal = totalPerNight * nights;
            displayTotal.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }

        checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
        checkInInput.addEventListener('change', calculateTotal);
        checkOutInput.addEventListener('change', calculateTotal);

        // Initial calculation
        calculateTotal();
    });
</script>
@endsection
