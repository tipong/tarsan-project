@extends('layouts.app')

@section('title', 'Invoice - ' . ($order->invoice_number ?? $order->order_code))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('tamu.orders') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden" id="invoice-content">
            {{-- Invoice Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold">INVOICE</h1>
                        <p class="text-blue-100 text-sm mt-1">{{ $order->invoice_number ?? $order->order_code }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-lg">Tarsan Homestay</p>
                        <p class="text-blue-100 text-sm">Labuan Bajo, Nusa Tenggara Timur</p>
                        <p class="text-blue-100 text-sm">tarsanhomestay@gmail.com</p>
                    </div>
                </div>
            </div>

            {{-- Invoice Body --}}
            <div class="p-8">
                {{-- Booking Details --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Booking Details</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-slate-500">Order Date</p>
                                <p class="font-medium text-slate-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Account Username</p>
                                <p class="font-medium text-slate-900">{{ $order->user->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500">Payment Status</p>
                                <p class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $order->payment_status === 'paid' ? 'Paid' : 'Not Paid' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">ID Transaksi</h3>
                        <p class="font-mono text-slate-900 font-bold text-lg">{{ $order->order_code ?? 'N/A' }}</p>
                        <p class="text-xs text-slate-500 mt-1">Use this code as reference</p>
                    </div>
                </div>

                {{-- Stay Details --}}
                <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Stay Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-slate-500">Check-in</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $order->check_in?->format('d M Y') ?? 'N/A' }}</p>
                            <p class="text-sm text-slate-500">from 14:00 WITA</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Check-out</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $order->check_out?->format('d M Y') ?? 'N/A' }}</p>
                            <p class="text-sm text-slate-500">before 12:00 WITA</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Duration</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $order->nights ?? 1 }} Night</p>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                @if($order->items && $order->items->count() > 0)
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Order Details</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-200">
                                    <th class="text-left py-3 px-4 text-sm font-semibold text-slate-600">Room</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-slate-600">Price/Night</th>
                                    <th class="text-center py-3 px-4 text-sm font-semibold text-slate-600">Nights</th>
                                    <th class="text-right py-3 px-4 text-sm font-semibold text-slate-600">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr class="border-b border-gray-100">
                                    <td class="py-3 px-4">
                                        <p class="font-medium text-slate-900">{{ $item->room->room_name ?? 'N/A' }}</p>
                                        @if($item->room && $item->room->capacity)
                                        <p class="text-sm text-slate-500">Kapasitas: {{ $item->room->capacity }} orang</p>
                                        @endif
                                    </td>
                                    <td class="text-center py-3 px-4 text-slate-700">
                                        Rp {{ number_format($item->price_per_night ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center py-3 px-4 text-slate-700">
                                        {{ $item->nights ?? $order->nights ?? 1 }}
                                    </td>
                                    <td class="text-right py-3 px-4 font-medium text-slate-900">
                                        Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="bg-indigo-50 rounded-2xl p-6 mb-8 border border-indigo-100">
                    <h3 class="text-sm font-semibold text-indigo-900 uppercase tracking-wider mb-4">Guest Information (Stay Details)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-indigo-400">Guest Name</p>
                            <p class="text-lg font-bold text-indigo-900">{{ $order->guest_name ?? $order->user->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-400">Phone Number</p>
                            <p class="text-lg font-bold text-indigo-900">{{ $order->guest_phone ?? $order->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-400">Contact Email</p>
                            <p class="text-lg font-bold text-indigo-900">{{ $order->user->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="border-t border-slate-200 pt-6">
                    <div class="max-w-sm ml-auto">
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
                            </div>
                            @if($order->discount_amount ?? 0 > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Diskon</span>
                                <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="border-t border-slate-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-slate-900">Total</span>
                                <span class="text-2xl font-bold text-indigo-600">
                                    Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Method --}}
                @if($order->payment_method)
                <div class="mt-6 bg-gray-50 rounded-2xl p-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Payment Method</h3>
                    <p class="font-medium text-slate-900">{{ ucfirst($order->payment_method) }}</p>
                </div>
                @endif

                {{-- Footer Note --}}
                <div class="mt-8 pt-6 border-t border-slate-200 text-center">
                    <p class="text-sm text-slate-500">
                        This invoice was automatically created and is valid without signature or stamp.
                    </p>
                    <p class="text-sm text-slate-500 mt-1">
                        Thank you for choosing Tarsan Homestay.
                    </p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex flex-wrap gap-3 justify-center">
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Invoice
            </button>
            <a href="{{ route('tamu.invoice.download', $order) }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium shadow">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Unduh PDF
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #invoice-content, #invoice-content * {
        visibility: visible;
    }
    #invoice-content {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endpush
