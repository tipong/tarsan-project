@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Pesanan Saya</h1>
            <p class="text-slate-600">Kelola semua pesanan hotel Anda di sini</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white p-12 rounded-2xl shadow border border-slate-200 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-slate-600 text-lg mb-4">Anda belum memiliki pesanan</p>
                <a href="{{ route('kamar.index') }}" class="inline-flex items-center gap-2 px-6 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Mulai Pesan Kamar
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white p-6 rounded-2xl shadow border border-slate-200 hover:shadow-md transition">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-4">
                            {{-- Order Code & Date --}}
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-medium mb-1">Kode Pesanan</p>
                                <p class="text-lg font-bold text-slate-900">{{ $order->order_code ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>

                            {{-- Check-in & Check-out --}}
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-medium mb-1">Tanggal</p>
                                @if($order->check_in_date && $order->check_out_date)
                                    <p class="text-lg font-bold text-slate-900">
                                        {{ $order->check_in_date->format('d M') }} - {{ $order->check_out_date->format('d M') }}
                                    </p>
                                @else
                                    <p class="text-lg font-bold text-slate-900">N/A</p>
                                @endif
                                <p class="text-xs text-slate-500 mt-1">{{ $order->nights ?? 1 }} malam</p>
                            </div>

                            {{-- Status --}}
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-medium mb-1">Status Pesanan</p>
                                <div class="mt-1">
                                    @if($order->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Tertunda
                                        </span>
                                    @elseif($order->status === 'confirmed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Dikonfirmasi
                                        </span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-slate-800">
                                            {{ $order->status }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Payment Status --}}
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-medium mb-1">Pembayaran</p>
                                @if($order->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sudah Dibayar
                                    </span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Menunggu Bayar
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-slate-800">
                                        {{ $order->payment_status }}
                                    </span>
                                @endif
                                <p class="text-sm font-semibold text-slate-900 mt-1">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Total Price --}}
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-medium mb-1">Total</p>
                                <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex flex-wrap gap-2 pt-4 border-t border-slate-200">
                            <a href="{{ route('tamu.orders.show', $order) }}"
                               class="px-4 py-2 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition duration-200 font-medium text-sm">
                                Lihat Detail
                            </a>

                            @if($order->status === 'pending' && $order->payment_status !== 'paid')
                                <button type="button"
                                        data-continue-payment
                                        data-order-id="{{ $order->id }}"
                                        class="px-4 py-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium text-sm">
                                    Lanjutkan Pembayaran
                                </button>
                            @endif

                            @if($order->payment_status === 'paid')
                                <a href="{{ route('tamu.invoice.show', $order) }}"
                                   class="px-4 py-2 bg-purple-600 text-white rounded-2xl hover:bg-purple-700 transition duration-200 font-medium text-sm">
                                    Lihat Invoice
                                </a>
                                <a href="{{ route('tamu.invoice.download', $order) }}"
                                   class="px-4 py-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium text-sm">
                                    Unduh PDF
                                </a>
                            @endif

                            @if(in_array($order->status, ['pending', 'confirmed']) && $order->payment_status !== 'paid')
                                <button type="button" onclick="cancelOrder({{ $order->id }})"
                                        class="px-4 py-2 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition duration-200 font-medium text-sm">
                                    Batalkan Pesanan
                                </button>
                            @endif

                            @if($order->checked_out_at && !$order->review)
                                <button type="button" onclick="openReviewModal({{ $order->id }})"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-2xl hover:bg-yellow-600 transition duration-200 font-medium text-sm">
                                    Beri Ulasan
                                </button>
                            @elseif($order->review)
                                <span class="px-4 py-2 bg-gray-100 text-gray-600 rounded-2xl font-medium text-sm">
                                    ⭐ {{ $order->review->rating }} / 5
                                </span>
                            @endif
                        </div>

                        {{-- Cancellation Reason Display --}}
                        @if($order->status === 'cancelled' && $order->cancelled_reason)
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-2xl">
                                <p class="text-sm text-red-700 font-medium mb-1">Alasan Pembatalan:</p>
                                <p class="text-sm text-red-600">{{ $order->cancelled_reason }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal Cancel Order --}}
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md w-full">
        <h3 class="text-xl font-bold text-slate-900 mb-4">Batalkan Pesanan</h3>
        <p class="text-slate-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan ini?</p>

        <form id="cancelForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Pembatalan</label>
                <textarea name="reason"
                          class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                          placeholder="Jelaskan alasan Anda membatalkan pesanan..."
                          required></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeCancelModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-slate-700 rounded-2xl hover:bg-gray-400 transition duration-200 font-medium">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition duration-200 font-medium">
                    Batalkan Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
{{-- Modal Review --}}
<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md w-full">
        <h3 class="text-xl font-bold text-slate-900 mb-4">Beri Ulasan</h3>
        <p class="text-slate-600 mb-4">Bagaimana pengalaman menginap Anda?</p>

        <form id="reviewForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Rating (1-5)</label>
                <select name="rating" class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 outline-none" required>
                    <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                    <option value="4">⭐⭐⭐⭐ Baik</option>
                    <option value="3">⭐⭐⭐ Cukup</option>
                    <option value="2">⭐⭐ Kurang</option>
                    <option value="1">⭐ Sangat Kurang</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Ulasan</label>
                <textarea name="review"
                          class="w-full px-4 py-2 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-600 focus:border-transparent outline-none transition"
                          placeholder="Ceritakan pengalaman Anda..."
                          required></textarea>
            </div>

            <div class="flex gap-3 mt-4">
                <button type="button" onclick="closeReviewModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-slate-700 rounded-2xl hover:bg-gray-400 transition duration-200 font-medium">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-yellow-500 text-white rounded-2xl hover:bg-yellow-600 transition duration-200 font-medium">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function cancelOrder(orderId) {
    const modal = document.getElementById('cancelModal');
    const form = document.getElementById('cancelForm');
    form.action = `/tamu/orders/${orderId}/cancel`;
    modal.classList.remove('hidden');
}

function closeCancelModal() {
    const modal = document.getElementById('cancelModal');
    modal.classList.add('hidden');
}

function openReviewModal(orderId) {
    const modal = document.getElementById('reviewModal');
    const form = document.getElementById('reviewForm');
    form.action = `/tamu/orders/${orderId}/review`;
    modal.classList.remove('hidden');
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
}

// Continue Payment Button Handler
document.addEventListener('DOMContentLoaded', function() {
    const continueButtons = document.querySelectorAll('[data-continue-payment]');
    continueButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            window.location.href = `/tamu/payment/${orderId}`;
        });
    });
});
</script>
@endsection
