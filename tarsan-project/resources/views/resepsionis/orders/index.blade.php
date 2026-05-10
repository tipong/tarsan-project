@extends('resepsionis.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Daftar Pesanan</h1>
                <p class="text-slate-600 mt-1">Kelola semua pesanan tamu di sini</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                <a href="{{ route('resepsionis.orders.walkin.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0 0h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Walk-in Booking
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Tamu</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Kamar</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Check-in</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Check-out</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Pembayaran</th>
                            <th class="px-6 py-3 text-left font-semibold text-slate-700">Status</th>
                            <th class="px-6 py-3 text-center font-semibold text-slate-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-900">{{ $order->user?->name ?? $order->guest_name ?? '-' }}</p>
                                @if($order->guest_phone)
                                <p class="text-xs text-slate-500">{{ $order->guest_phone }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($order->items && $order->items->count() > 0)
                                    @foreach($order->items as $item)
                                        <div class="text-sm font-medium text-slate-900">{{ $item->room?->room_name ?? '-' }}</div>
                                    @endforeach
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">{{ $order->check_in ? $order->check_in->format('d M Y') : '-' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-slate-900">{{ $order->check_out ? $order->check_out->format('d M Y') : '-' }}</p>
                            </td>

                            {{-- Payment Status --}}
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Lunas
                                    </span>
                                @elseif($order->payment_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-50 text-slate-600">
                                        {{ $order->payment_status ?? '-' }}
                                    </span>
                                @endif
                            </td>

                            {{-- Operational Status --}}
                            <td class="px-6 py-4">
                                @if($order->status === 'cancelled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        Dibatalkan
                                    </span>
                                @elseif($order->checked_out_at)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                @elseif($order->checked_in_at)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                        Check-in
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        Menunggu
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($order->status !== 'cancelled' && !$order->checked_in_at)
                                    <form method="POST" action="{{ route('resepsionis.orders.checkin', $order) }}" class="inline checkin-form">
                                        @csrf
                                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition duration-200 font-medium text-xs" onclick="confirmCheckIn(this)">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m8 0l4 4m-4 4l-4-4"></path>
                                            </svg>
                                            Check-in
                                        </button>
                                    </form>
                                @elseif($order->checked_in_at && !$order->checked_out_at)
                                    <form method="POST" action="{{ route('resepsionis.orders.checkout', $order) }}" class="inline checkout-form">
                                        @csrf
                                        <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition duration-200 font-medium text-xs" onclick="confirmCheckOut(this)">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m-8 0l-4 4m4 4l4-4"></path>
                                            </svg>
                                            Check-out
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-500 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-slate-500">Tidak ada data pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmCheckIn(button) {
    Swal.fire({
        title: 'Konfirmasi Check-in',
        text: 'Apakah Anda yakin ingin melakukan check-in untuk tamu ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Check-in',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

function confirmCheckOut(button) {
    Swal.fire({
        title: 'Konfirmasi Check-out',
        text: 'Apakah Anda yakin ingin melakukan check-out untuk tamu ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Check-out',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}
</script>
@endsection
