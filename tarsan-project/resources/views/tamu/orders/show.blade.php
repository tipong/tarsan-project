@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm text-slate-600">
        <a href="{{ route('tamu.orders') }}" class="hover:text-indigo-600">Pesanan Saya</a>
        <span>›</span>
        <span class="text-slate-800">{{ $order->order_code }}</span>
    </div>

    {{-- Order Header --}}
    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-slate-600 mb-1">Kode Pesanan</p>
                <h1 class="text-2xl font-bold text-slate-800">{{ $order->order_code ?? 'N/A' }}</h1>
                <p class="text-xs text-slate-500 mt-2">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>

            <div>
                <p class="text-sm text-slate-600 mb-1">Status Pesanan</p>
                <div class="mt-1">
                    @if($order->status === 'completed')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">✓ Selesai</span>
                    @elseif($order->status === 'cancelled')
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">✗ Dibatalkan</span>
                    @elseif($order->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">⏳ Menunggu Pembayaran</span>
                    @elseif($order->status === 'confirmed')
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">📋 Dikonfirmasi</span>
                    @else
                        <span class="px-3 py-1 bg-gray-50 text-slate-700 rounded-full text-sm font-semibold">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-sm text-slate-600 mb-1">Status Pembayaran</p>
                <div class="mt-1">
                    @if($order->payment_status === 'paid')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">✓ Lunas</span>
                    @elseif($order->payment_status === 'refunded')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">↩️ Dikembalikan</span>
                    @elseif($order->payment_status === 'expired')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">⏰ Kedaluwarsa</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">✗ Gagal</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">⏳ Menunggu Pembayaran</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Guest & Room Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Guest Information --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Tamu</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-slate-600">Nama Tamu</p>
                    <p class="font-semibold text-slate-800">{{ $order->guest_display_name }}</p>
                </div>
                @if($order->guest_phone)
                    <div>
                        <p class="text-sm text-slate-600">Nomor Telepon</p>
                        <p class="font-semibold text-slate-800">{{ $order->guest_phone }}</p>
                    </div>
                @endif
                @if($order->user)
                    <div>
                        <p class="text-sm text-slate-600">Email</p>
                        <p class="font-semibold text-slate-800">{{ $order->user->email }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Room Information --}}
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Kamar</h3>
            @php
                $primaryRoom = $order->room ?? optional($order->items->first())->room;
            @endphp
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-slate-600">Nama Kamar</p>
                    <p class="font-semibold text-slate-800">{{ $primaryRoom->room_name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Check-in</p>
                    <p class="font-semibold text-slate-800">
                        @if($order->check_in_date)
                            {{ $order->check_in_date->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Check-out</p>
                    <p class="font-semibold text-slate-800">
                        @if($order->check_out_date)
                            {{ $order->check_out_date->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Durasi Menginap</p>
                    <p class="font-semibold text-slate-800">{{ $order->nights ?? 1 }} malam</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Pricing Details --}}
    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Rincian Harga</h3>

        @if($order->items->count() > 0)
            <div class="space-y-2 mb-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between">
                        <span>{{ $item->room->room_name }} × {{ $item->nights }} malam</span>
                        <span class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="border-t pt-4">
            <div class="flex justify-between text-lg">
                <span class="font-bold">Total</span>
                <span class="font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            @if($order->payment_method)
                <p class="text-sm text-slate-600 mt-2">
                    <strong>Metode Pembayaran:</strong>
                    @if($order->payment_method === 'cash')
                        💵 Tunai
                    @elseif($order->payment_method === 'bank_transfer')
                        🏦 Transfer Bank
                    @else
                        💳 Kartu Kredit
                    @endif
                </p>
            @endif
        </div>
    </div>

    {{-- Cancellation Reason (if cancelled) --}}
    @if($order->status === 'cancelled' && $order->cancelled_reason)
        <div class="bg-red-50 border border-red-200 p-6 rounded-2xl shadow-md mb-6">
            <h3 class="text-lg font-bold text-red-800 mb-3">Informasi Pembatalan</h3>
            <div>
                <p class="text-sm text-red-700 mb-2"><strong>Dibatalkan pada:</strong></p>
                <p class="text-red-600 mb-4">
                    @if($order->cancelled_at)
                        {{ $order->cancelled_at->format('d M Y H:i') }}
                    @else
                        N/A
                    @endif
                </p>

                <p class="text-sm text-red-700 mb-2"><strong>Alasan:</strong></p>
                <p class="text-red-600">{{ $order->cancelled_reason }}</p>
            </div>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('tamu.orders') }}"
           class="px-6 py-2 bg-gray-300 text-slate-700 rounded-2xl hover:bg-gray-400 transition">
            ← Kembali
        </a>

        @if($order->payment_status === 'paid')
            <a href="{{ route('tamu.invoice.show', $order->id) }}"
               class="px-6 py-2 bg-purple-600 text-white rounded-2xl hover:bg-purple-700 transition">
                📄 Lihat Invoice
            </a>
        @endif

        @if($order->status === 'pending' && $order->payment_status !== 'paid')
            <button type="button"
                    data-continue-payment
                    data-order-id="{{ $order->id }}"
                    class="px-6 py-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition">
                💳 Lanjutkan Pembayaran
            </button>
        @endif

        @if(in_array($order->status, ['pending', 'confirmed']))
            <button type="button" onclick="cancelOrder({{ $order->id }})"
                   class="px-6 py-2 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition">
                ✗ Batalkan Pesanan
            </button>
        @endif

        @if($order->checked_out_at && !$order->review)
            <button type="button" onclick="openReviewModal({{ $order->id }})"
                    class="px-6 py-2 bg-yellow-500 text-white rounded-2xl hover:bg-yellow-600 transition">
                ⭐ Beri Ulasan
            </button>
        @elseif($order->review)
            <span class="px-6 py-2 bg-gray-100 text-gray-600 rounded-2xl font-medium">
                ⭐ {{ $order->review->rating }} / 5 (Sudah Diulas)
            </span>
        @endif
    </div>
</div>

{{-- Cancel Modal --}}
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-2xl shadow-lg max-w-md w-full mx-4">
        <h3 class="text-xl font-bold text-slate-800 mb-4">Batalkan Pesanan</h3>
        <p class="text-slate-600 mb-4">Apakah Anda yakin ingin membatalkan pesanan ini?</p>

        <form id="cancelForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Pembatalan</label>
                <textarea name="reason" class="w-full px-4 py-2 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-red-500 outline-none"
                          placeholder="Jelaskan alasan Anda membatalkan pesanan..." required></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeCancelModal()"
                        class="flex-1 px-4 py-2 bg-gray-300 text-slate-700 rounded-2xl hover:bg-gray-400">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-2xl hover:bg-red-700">
                    Batalkan Pesanan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Review Modal --}}
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

<script>
let currentOrderId = {{ $order->id }};

function cancelOrder(orderId) {
    currentOrderId = orderId;
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
    document.getElementById('cancelForm').reset();
}

document.getElementById('cancelForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const reason = formData.get('reason');

    if (!reason.trim()) {
        showError('Validasi', 'Alasan pembatalan tidak boleh kosong');
        return;
    }

    fetch(`/tamu/orders/${currentOrderId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        closeCancelModal();
        if (data.success) {
            showSuccess('Berhasil', data.message);
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showError('Gagal', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error', 'Terjadi kesalahan saat membatalkan pesanan');
    });
});

function openReviewModal(orderId) {
    const modal = document.getElementById('reviewModal');
    const form = document.getElementById('reviewForm');
    form.action = `/tamu/orders/${orderId}/review`;
    modal.classList.remove('hidden');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewForm').reset();
}

document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});

document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>
@include('tamu.orders.partials.continue-payment-script')
@endsection
