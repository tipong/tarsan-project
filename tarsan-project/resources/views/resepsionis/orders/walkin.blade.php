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
                Kembali ke Daftar Pesanan
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Walk-in Booking</h1>
            <p class="text-slate-600 mt-1">Buat pesanan baru untuk tamu walk-in</p>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('resepsionis.orders.walkin.store') }}">
            @csrf

            {{-- Guest Information --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Tamu
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Nama Tamu <span class="text-red-500">*</span></label>
                        <input type="text"
                               name="guest_name"
                               placeholder="Masukkan nama lengkap tamu"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
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
                    Informasi Kamar
                </h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Pilih Kamar <span class="text-red-500">*</span></label>
                    <select name="room_id" class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">
                                {{ $room->room_name }} — Rp {{ number_format($room->price_per_night, 0, ',', '.') }}/malam
                                (Kapasitas: {{ $room->capacity }} orang)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Check-in <span class="text-red-500">*</span></label>
                        <input type="date" name="check_in_date" required class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Check-out <span class="text-red-500">*</span></label>
                        <input type="date" name="check_out_date" required class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>
                </div>
            </div>

            {{-- Payment Method --}}
            <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Metode Pembayaran
                </h3>

                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="payment_method" value="cash" class="mr-3 text-indigo-600 focus:ring-indigo-600" checked>
                        <span class="text-slate-700">💵 Tunai (Cash)</span>
                    </label>

                    <label class="flex items-center p-3 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="payment_method" value="bank_transfer" class="mr-3 text-indigo-600 focus:ring-indigo-600">
                        <span class="text-slate-700">🏦 Transfer Bank</span>
                    </label>

                    <label class="flex items-center p-3 border border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-50 transition">
                        <input type="radio" name="payment_method" value="card" class="mr-3 text-indigo-600 focus:ring-indigo-600">
                        <span class="text-slate-700">💳 Kartu Kredit</span>
                    </label>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3">
                <a href="{{ route('resepsionis.orders.index') }}"
                   class="flex-1 px-6 py-2.5 bg-slate-100 text-slate-700 rounded-2xl hover:bg-gray-300 transition duration-200 font-medium text-center">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-6 py-2.5 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium">
                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan & Check-in
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
