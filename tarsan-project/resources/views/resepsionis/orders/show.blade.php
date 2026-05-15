@extends('resepsionis.layouts.app')

@section('title', 'Detail Pesanan - ' . $order->order_code)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm text-slate-600">
        <a href="{{ route('resepsionis.orders.index') }}" class="hover:text-blue-600 font-medium">Daftar Pesanan</a>
        <span class="text-slate-400">/</span>
        <span class="text-slate-900 font-semibold">{{ $order->order_code }}</span>
    </div>

    {{-- Order Header --}}
    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Order Code</p>
                <h1 class="text-2xl font-bold text-slate-900">{{ $order->order_code ?? 'N/A' }}</h1>
                <p class="text-xs text-slate-500 mt-1">Created on: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('tamu.invoice.show', $order) }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    View Invoice
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 pt-8 border-t border-slate-100">
            <div>
                <p class="text-sm font-semibold text-slate-500 mb-2">Order Status</p>
                <div>
                    @if($order->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">✓ COMPLETED</span>
                    @elseif($order->status === 'cancelled')
                        <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">✗ CANCELLED</span>
                    @elseif($order->status === 'pending')
                        <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">⏳ PENDING</span>
                    @elseif($order->status === 'confirmed')
                        <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">📋 CONFIRMED</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-slate-700 rounded-full text-xs font-bold uppercase">{{ $order->status }}</span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-sm font-semibold text-slate-500 mb-2">Payment Status</p>
                <div>
                    @if($order->payment_status === 'paid')
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">✓ PAID</span>
                    @elseif($order->payment_status === 'refunded')
                        <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">↩️ REFUNDED</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">{{ $order->payment_status ?? 'PENDING' }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Main Info Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Guest Info --}}
        <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <div class="p-1.5 bg-blue-50 rounded-lg">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                Data Tamu
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Tamu</p>
                    <p class="font-bold text-slate-900 text-lg">{{ $order->guest_name ?? $order->user?->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">WhatsApp / Telepon</p>
                    <p class="font-medium text-slate-800">{{ $order->guest_phone ?? $order->user?->phone ?? '-' }}</p>
                </div>
                @if($order->user)
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Email Akun</p>
                    <p class="font-medium text-slate-800">{{ $order->user->email }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Stay Info --}}
        <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <div class="p-1.5 bg-green-50 rounded-lg">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                Waktu Menginap
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Check-in</p>
                        <p class="font-bold text-slate-900">{{ $order->check_in ? $order->check_in->format('d M Y') : 'N/A' }}</p>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Check-out</p>
                        <p class="font-bold text-slate-900">{{ $order->check_out ? $order->check_out->format('d M Y') : 'N/A' }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between px-2">
                    <p class="text-sm font-medium text-slate-500">Durasi</p>
                    <p class="font-bold text-slate-900">{{ $order->nights ?? 1 }} Night(s)</p>
                </div>

                @if($order->checked_in_at)
                <div class="pt-2">
                    <p class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Guest checked in at:</p>
                    <p class="text-sm font-medium text-slate-700">{{ $order->checked_in_at->format('d M Y, H:i') }}</p>
                </div>
                @endif

                @if($order->checked_out_at)
                <div class="pt-2">
                    <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Guest checked out at:</p>
                    <p class="text-sm font-medium text-slate-700">{{ $order->checked_out_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Order Items Table --}}
    <div class="bg-white rounded-2xl shadow-md border border-slate-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-50">
            <h3 class="font-bold text-slate-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Rincian Kamar
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold text-slate-500">Tipe Kamar</th>
                        <th class="px-6 py-3 text-center font-bold text-slate-500">Harga / Malam</th>
                        <th class="px-6 py-3 text-center font-bold text-slate-500">Malam</th>
                        <th class="px-6 py-3 text-right font-bold text-slate-500">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $item->room->room_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-center">Rp {{ number_format($item->price_per_night, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center font-medium">{{ $item->nights }}</td>
                        <td class="px-6 py-4 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-slate-50">
                    @if($order->discount_amount > 0)
                    <tr>
                        <td colspan="3" class="px-6 py-2 text-right font-medium text-slate-500">Diskon</td>
                        <td class="px-6 py-2 text-right font-bold text-green-600">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-900 text-lg">Total Akhir</td>
                        <td class="px-6 py-4 text-right font-black text-blue-600 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="flex flex-wrap gap-3 items-center justify-between pt-4">
        <a href="{{ route('resepsionis.orders.index') }}"
           class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-2xl hover:bg-slate-200 transition duration-200 font-bold text-sm">
            ← Back to List
        </a>

        <div class="flex gap-2">
            @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                <form method="POST" action="{{ route('resepsionis.orders.checkin', $order) }}">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-bold text-sm shadow-md">
                        Check-in Tamu
                    </button>
                </form>
            @endif

            @if($order->checked_in_at && !$order->checked_out_at)
                <form method="POST" action="{{ route('resepsionis.orders.checkout', $order) }}">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition duration-200 font-bold text-sm shadow-md">
                        Check-out Tamu
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
