@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">All Transactions</h1>
        <p class="text-slate-500 mt-1">List of all incoming orders from guests</p>
    </div>
</div>

{{-- FILTER SECTION --}}
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div class="sm:col-span-2 lg:col-span-1">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Search Order</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Guest name / Code..."
                   class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-sm outline-none transition-all shadow-sm">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Status</label>
            <select name="status" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-sm outline-none transition-all shadow-sm cursor-pointer">
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
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Check-in Date</label>
            <input type="date" name="date" value="{{ request('date') }}"
                   class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-sm outline-none transition-all shadow-sm">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2.5">Room Type</label>
            <select name="room_id" class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-sm outline-none transition-all shadow-sm cursor-pointer">
                <option value="">All Rooms</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ request('room_id')==$room->id?'selected':'' }}>{{ $room->room_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button class="flex-1 bg-slate-900 text-white px-4 py-3 rounded-2xl hover:bg-slate-800 transition font-bold text-sm shadow-md">
                Filter
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold text-sm text-center">
                Reset
            </a>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
@endif

{{-- DATA TABLE --}}
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[950px]">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Guest</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Schedule</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                        <td class="px-6 py-4.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold shrink-0 shadow-inner">
                                    {{ strtoupper(substr($order->user?->name ?? $order->guest_name ?? 'G', 0, 2)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-800 text-sm group-hover:text-indigo-600 transition-colors duration-200">{{ $order->user?->name ?? $order->guest_name ?? '-' }}</span>
                                    <span class="text-[10px] text-slate-400 font-mono font-bold uppercase mt-0.5">#{{ $order->order_code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4.5">
                            @if($order->items->count() > 0)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($order->items as $item)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100/50">
                                            {{ $item->room?->room_name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4.5 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="flex items-center gap-1 text-slate-700 font-semibold text-xs">
                                    <span>{{ $order->check_in->format('d M Y') }}</span>
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                    <span>{{ $order->check_out->format('d M Y') }}</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-medium mt-1">({{ $order->nights }} Nights)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4.5 text-center">
                            @if($order->payment_status === 'paid')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-black uppercase">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-full text-[10px] font-black uppercase">
                                    <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4.5 text-center">
                            @if($order->status === 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-1 bg-rose-50 text-rose-700 border border-rose-200 rounded-full text-[10px] font-black uppercase">Cancelled</span>
                            @elseif($order->checked_out_at)
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-50 text-slate-500 border border-slate-200 rounded-full text-[10px] font-black uppercase">Completed</span>
                            @elseif($order->checked_in_at)
                                <span class="inline-flex items-center px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full text-[10px] font-black uppercase">Checked-in</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-black uppercase">Waiting</span>
                            @endif
                        </td>
                        <td class="px-6 py-4.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                                    <button onclick="confirmAction('{{ route('admin.orders.checkin', $order) }}', 'Check-in', 'Are you sure you want to check-in this guest?')"
                                            class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm hover:shadow transition duration-200 font-bold text-[10px]">
                                        Check-in
                                    </button>
                                @endif

                                @if($order->checked_in_at && !$order->checked_out_at)
                                    <button onclick="confirmAction('{{ route('admin.orders.checkout', $order) }}', 'Check-out', 'Are you sure you want to check-out this guest?', '#ef4444')"
                                            class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm hover:shadow transition duration-200 font-bold text-[10px]">
                                        Check-out
                                    </button>
                                @endif

                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="px-3 py-1.5 bg-slate-50 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-100 text-indigo-600 rounded-xl transition duration-200 font-bold text-[10px] inline-flex items-center gap-1 hover:shadow-sm" title="Detail">
                                    Detail
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
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
