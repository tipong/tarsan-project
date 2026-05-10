@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900">Rincian Pemesanan</h1>
            <a href="{{ route('tamu.booking.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kamar
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            {{-- LEFT: Room List --}}
            <div class="md:col-span-2 space-y-4">
                @forelse($cart as $item)
                    <div class="bg-white p-6 rounded-2xl shadow border border-slate-200">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-slate-900">{{ $item['room_name'] }}</h4>
                                <p class="text-sm text-slate-600 mt-2">
                                    {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} →
                                    {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}
                                </p>
                                <p class="text-sm text-slate-500 mt-1">{{ $item['nights'] }} malam</p>
                            </div>

                            <div class="text-right">
                                <p class="text-lg font-bold text-slate-900">
                                    Rp {{ number_format($item['subtotal']) }}
                                </p>
                                <form method="POST"
                                      action="{{ route('tamu.booking.remove', $item['room_id']) }}"
                                      class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-sm text-red-600 hover:text-red-700 transition font-medium">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-8 rounded-2xl shadow border border-slate-200 text-center">
                        <p class="text-slate-500">Tidak ada kamar yang dipilih</p>
                    </div>
                @endforelse
            </div>

            {{-- RIGHT: Guest Information & Summary --}}
            <div class="space-y-6">
                {{-- Guest Information Form --}}
                <form method="POST" action="{{ route('tamu.reservation.guest') }}"
                    class="bg-white rounded-2xl shadow border border-slate-200 p-6">
                    @csrf

                    <h3 class="text-lg font-bold text-slate-900 mb-4">Data Tamu</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Tamu *</label>
                            <input type="text"
                                name="name"
                                value="{{ session('guest.name') }}"
                                class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon *</label>
                            <input type="text"
                                name="phone"
                                value="{{ session('guest.phone') }}"
                                class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Kode Voucher (Opsional)
                            </label>
                            <input type="text"
                                name="voucher"
                                value="{{ session('voucher.code') }}"
                                class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                                placeholder="Masukkan kode voucher...">
                            @error('voucher')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm">
                            Simpan Data Tamu
                        </button>
                    </div>
                </form>

                {{-- Booking Summary --}}
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

                <div class="bg-white rounded-2xl shadow border border-slate-200 p-6 h-fit">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Ringkasan Biaya</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Subtotal</span>
                            <span class="font-semibold text-slate-900">Rp {{ number_format($subtotal) }}</span>
                        </div>

                        @if($voucherDiscount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Diskon Voucher</span>
                                <span class="font-semibold">- Rp {{ number_format($voucherDiscount) }}</span>
                            </div>
                        @endif

                        <div class="border-t border-slate-200 pt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-900">Total</span>
                                <span class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($finalTotal) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @php
                        $guestReady = session()->has('guest.name')
                                    && session()->has('guest.phone');
                    @endphp

                    @if($guestReady)
                        <a href="{{ route('tamu.payment.index') }}"
                        class="block w-full mt-6 px-4 py-3 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-bold text-center">
                            Lanjut ke Pembayaran
                        </a>
                    @else
                        <button disabled
                            class="block w-full mt-6 px-4 py-3 bg-gray-300 text-slate-500 rounded-2xl cursor-not-allowed font-bold">
                            Isi Data Tamu Terlebih Dahulu
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
