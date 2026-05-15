@extends('resepsionis.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Manajemen Pesanan</h1>
        <p class="text-slate-500 mt-1">Pantau check-in, check-out, dan booking baru</p>
    </div>
    <button onclick="openWalkinModal()"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-2xl hover:bg-emerald-700 transition duration-200 font-bold text-sm shadow-lg shadow-emerald-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Walk-in Booking
    </button>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Tamu</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Kamar</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Check-in/out</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Pembayaran</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Status</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900">{{ $order->user?->name ?? $order->guest_name ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">#{{ $order->order_code }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($order->items->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($order->items as $item)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $item->room?->room_name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xs font-bold text-slate-700">{{ $order->check_in->format('d M') }} - {{ $order->check_out->format('d M') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $order->nights }} Malam</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($order->payment_status === 'paid')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Paid</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($order->status === 'cancelled')
                                <span class="px-2 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Cancelled</span>
                            @elseif($order->checked_out_at)
                                <span class="px-2 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-black uppercase tracking-tighter">Completed</span>
                            @elseif($order->checked_in_at)
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Check-in</span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                                    <button onclick="confirmAction('{{ route('resepsionis.orders.checkin', $order) }}', 'Check-in', 'Yakin ingin memproses check-in tamu ini?')"
                                            class="px-3 py-1.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-bold text-[10px]">
                                        Check-in
                                    </button>
                                @endif

                                @if($order->checked_in_at && !$order->checked_out_at)
                                    <button onclick="confirmAction('{{ route('resepsionis.orders.checkout', $order) }}', 'Check-out', 'Yakin ingin memproses check-out tamu ini?', '#ef4444')"
                                            class="px-3 py-1.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-bold text-[10px]">
                                        Check-out
                                    </button>
                                @endif

                                <a href="{{ route('resepsionis.orders.show', $order) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition duration-200" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- WALK-IN MODAL --}}
<div id="walkinModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="walkinModalContent">
        <div class="p-8 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-8 sticky top-0 bg-white z-10 pb-4">
                <h2 class="text-2xl font-black text-slate-900">Walk-in Booking</h2>
                <button onclick="closeWalkinModal()" class="p-2 hover:bg-slate-50 rounded-full transition duration-200 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('resepsionis.orders.walkin.store') }}" method="POST" id="walkinForm" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nama Tamu</label>
                        <input type="text" name="guest_name" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-emerald-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                               placeholder="Nama Lengkap">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">WhatsApp / HP</label>
                        <input type="tel" name="guest_phone" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-emerald-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                               placeholder="08xxxxxxxx">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Select Rooms (Multiple OK)</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 bg-slate-50 p-6 rounded-3xl max-h-48 overflow-y-auto">
                        @foreach($rooms as $room)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" name="room_ids[]" value="{{ $room->id }}" data-price="{{ $room->price_per_night }}"
                                       class="room-checkbox rounded-lg border-slate-200 text-emerald-600 focus:ring-emerald-600 transition duration-200">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-700 uppercase group-hover:text-emerald-600 transition">{{ $room->room_name }}</span>
                                    <span class="text-[8px] text-slate-400">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Tgl Check-in</label>
                        <input type="date" name="check_in_date" id="checkInDate" value="{{ date('Y-m-d') }}" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-emerald-600 text-xs text-slate-900 font-medium outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Tgl Check-out</label>
                        <input type="date" name="check_out_date" id="checkOutDate" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-emerald-600 text-xs text-slate-900 font-medium outline-none transition-all">
                    </div>
                </div>

                {{-- Summary --}}
                <div class="bg-slate-900 p-6 rounded-[2rem] text-white flex justify-between items-center shadow-xl shadow-slate-100">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Estimasi</p>
                        <h2 class="text-2xl font-black text-emerald-400" id="displayTotalPrice">Rp 0</h2>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Durasi</p>
                        <p class="font-bold" id="displayNights">1 Malam</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Metode Pembayaran</label>
                    <div class="flex gap-4">
                        <label class="flex-1 flex items-center justify-center gap-2 p-4 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-emerald-500 cursor-pointer transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 group">
                            <input type="radio" name="payment_method" value="cash" checked class="hidden">
                            <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-700">💵 TUNAI</span>
                        </label>
                        <label class="flex-1 flex items-center justify-center gap-2 p-4 bg-slate-50 rounded-2xl border-2 border-transparent hover:border-emerald-500 cursor-pointer transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-500 group">
                            <input type="radio" name="payment_method" value="bank_transfer" class="hidden">
                            <span class="text-xs font-bold text-slate-600 group-hover:text-emerald-700">🏦 TRANSFER</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeWalkinModal()"
                            class="flex-1 px-6 py-4 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition font-bold text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-emerald-600 text-white rounded-2xl hover:bg-emerald-700 transition shadow-xl shadow-emerald-100 font-bold text-sm">
                        Save & Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Confirm Form --}}
<form id="confirmActionForm" method="POST" class="hidden">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openWalkinModal() {
        const modal = document.getElementById('walkinModal');
        const content = document.getElementById('walkinModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 10);
        calculateTotal();
    }

    function closeWalkinModal() {
        const modal = document.getElementById('walkinModal');
        const content = document.getElementById('walkinModalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function calculateTotal() {
        const checkboxes = document.querySelectorAll('.room-checkbox');
        const checkInInput = document.getElementById('checkInDate');
        const checkOutInput = document.getElementById('checkOutDate');
        const displayTotal = document.getElementById('displayTotalPrice');
        const displayNights = document.getElementById('displayNights');

        const checkIn = new Date(checkInInput.value);
        const checkOut = new Date(checkOutInput.value);

        let nights = 0;
        if (checkIn && checkOut && checkOut > checkIn) {
            nights = Math.ceil(Math.abs(checkOut - checkIn) / (1000 * 60 * 60 * 24));
        }
        if (nights <= 0) nights = 1;

        displayNights.innerText = nights + ' Malam';

        let totalPerNight = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) totalPerNight += parseInt(cb.dataset.price);
        });

        displayTotal.innerText = 'Rp ' + (totalPerNight * nights).toLocaleString('id-ID');
    }

    document.querySelectorAll('.room-checkbox, #checkInDate, #checkOutDate').forEach(el => {
        el.addEventListener('change', calculateTotal);
    });

    function confirmAction(url, title, text, color = '#4f46e5') {
        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: color,
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Yes, Continue',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl px-6 py-3 font-bold',
                cancelButton: 'rounded-xl px-6 py-3 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('confirmActionForm');
                form.action = url;
                form.submit();
            }
        });
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection
