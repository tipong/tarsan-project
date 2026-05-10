@extends('resepsionis.layouts.app')

@section('title', 'Availability Kamar')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('resepsionis.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-200 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Cek Ketersediaan Kamar</h1>
            <p class="text-slate-600 mt-1">Pilih tanggal untuk melihat kamar yang tersedia</p>
        </div>

        {{-- Filter Form --}}
        <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 mb-8">
            <form method="POST" action="{{ route('resepsionis.availability.check') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Check-in --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Check-in</label>
                        <input type="date" name="check_in" required
                               value="{{ $checkIn ?? date('Y-m-d') }}"
                               class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition">
                    </div>

                    {{-- Check-out --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Check-out</label>
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
                            Cek Ketersediaan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results --}}
        @if(isset($rooms))
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-semibold text-slate-900">
                    Hasil Pencarian
                    <span class="text-sm font-normal text-slate-500 ml-2">
                        ({{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('d M Y') : '-' }} - {{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('d M Y') : '-' }})
                    </span>
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Kamar</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Harga/Malam</th>
                            <th class="px-6 py-3 text-center font-semibold text-slate-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $data)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $data['room']->room_name ?? '-' }}</p>
                                <p class="text-xs text-slate-500">Kapasitas: {{ $data['room']->capacity ?? '-' }} orang</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">Rp {{ number_format($data['room']->price_per_night ?? 0, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($data['available'])
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($data['available'])
                                    <a href="{{ route('resepsionis.orders.walkin.create', [
                                        'room_id' => $data['room']->id,
                                        'check_in' => $checkIn,
                                        'check_out' => $checkOut
                                    ]) }}"
                                       class="inline-flex items-center gap-1 px-4 py-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                        Booking
                                    </a>
                                @else
                                    <span class="text-slate-500 text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-slate-500">Silakan pilih tanggal dan tekan tombol "Cek Ketersediaan" untuk melihat kamar yang tersedia.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
