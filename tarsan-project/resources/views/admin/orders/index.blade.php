@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">All Transactions</h1>
        <p class="text-slate-500 mt-1">List of all incoming orders from guests</p>
    </div>
</div>

{{-- FILTER SECTION --}}
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div class="md:col-span-1">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Search Order</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Guest name / Code..."
                   class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status</label>
            <select name="status" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
                <option value="">All Status</option>
                <option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>Upcoming</option>
                <option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>In Progress</option>
                <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
                <option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option>
                <option value="unpaid" {{ request('status')=='unpaid'?'selected':'' }}>Unpaid</option>
            </select>
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Check-in Date</label>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Room Type</label>
            <select name="room_id" class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
                <option value="">All Rooms</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id')==$room->id?'selected':'' }}>{{ $room->room_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button class="flex-1 bg-slate-900 text-white px-4 py-3 rounded-2xl hover:bg-slate-800 transition font-bold text-sm">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold text-sm">
                Reset
            </a>
        </div>
    </form>
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
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Guest</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Room</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Schedule</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Payment</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Status</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Action</th>
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
                                @foreach($order->items as $item)
                                    <div class="text-[10px] font-bold text-slate-600">{{ $item->room?->room_name }}</div>
                                @endforeach
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xs font-bold text-slate-700">{{ $order->check_in->format('d M') }} - {{ $order->check_out->format('d M') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">{{ $order->nights }} Night</span>
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
                                <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Checked-in</span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Waiting</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                                    <button onclick="confirmAction('{{ route('admin.orders.checkin', $order) }}', 'Check-in', 'Are you sure you want to check-in this guest?')"
                                            class="px-3 py-1.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-bold text-[10px]">
                                        Check-in
                                    </button>
                                @endif

                                @if($order->checked_in_at && !$order->checked_out_at)
                                    <button onclick="confirmAction('{{ route('admin.orders.checkout', $order) }}', 'Check-out', 'Are you sure you want to check-out this guest?', '#ef4444')"
                                            class="px-3 py-1.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-bold text-[10px]">
                                        Check-out
                                    </button>
                                @endif

                                <a href="{{ route('admin.orders.show', $order) }}"
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

<div class="mt-6">
    {{ $orders->links() }}
</div>

{{-- Confirm Form --}}
<form id="confirmActionForm" method="POST" class="hidden">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
@endsection
