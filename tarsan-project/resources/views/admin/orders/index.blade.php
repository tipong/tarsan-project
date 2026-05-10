@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

<h1 class="text-xl font-semibold mb-4">Orders</h1>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm">
        {{ session('success') }}
    </div>
@endif

<form method="GET" class="mb-4 flex flex-wrap gap-3 items-end">

    {{-- SEARCH --}}
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search guest / room"
        class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800">

    {{-- STATUS --}}
    <select name="status" class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 w-40">
        <option value="">All Status</option>
        <option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>
            Akan Datang
        </option>
        <option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>
            Sedang Menginap
        </option>
        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>
            Selesai
        </option>
        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>
            Dibatalkan
        </option>
        <option value="paid" {{ request('status')=='paid'?'selected':'' }}>
            Sudah Dibayar
        </option>
        <option value="unpaid" {{ request('status')=='unpaid'?'selected':'' }}>
            Belum Dibayar
        </option>
    </select>

    {{-- DATE --}}
    <input
        type="date"
        name="date"
        value="{{ request('date') }}"
        class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800">

    {{-- ROOM --}}
    <select name="room_id" class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 w-48">
        <option value="">All Rooms</option>
        @foreach($rooms as $room)
            <option value="{{ $room->id }}"
                {{ request('room_id')==$room->id?'selected':'' }}>
                {{ $room->room_name }}
            </option>
        @endforeach
    </select>

    {{-- BUTTON --}}
    <button class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm font-medium">
        Filter
    </button>

    <a href="{{ route('admin.orders.index') }}"
       class="px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700">
        Reset
    </a>
</form>

<div class="bg-white rounded-xl shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-slate-50">
        <tr>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Guest</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Check In</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Check Out</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Payment</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
        </tr>
    </thead>

    <tbody>
    @forelse($orders as $order)
        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
            <td class="px-6 py-4 border-b border-slate-50 text-sm">{{ $order->user?->name ?? $order->guest_name ?? '-' }}</td>
            <td class="px-6 py-4 border-b border-slate-50 text-sm">
                @if($order->items && $order->items->count() > 0)
                    @foreach($order->items as $item)
                        <div class="text-xs">{{ $item->room?->room_name ?? '-' }}</div>
                    @endforeach
                @else
                    <span class="text-slate-500">-</span>
                @endif
            </td>
            <td class="px-6 py-4 border-b border-slate-50 text-sm">{{ $order->check_in ? $order->check_in->format('d M Y') : '-' }}</td>
            <td class="px-6 py-4 border-b border-slate-50 text-sm">{{ $order->check_out ? $order->check_out->format('d M Y') : '-' }}</td>

            {{-- Payment Status --}}
            <td class="px-6 py-4 border-b border-slate-50 text-sm">
                @if($order->payment_status === 'paid')
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                        Lunas
                    </span>
                @elseif($order->payment_status === 'pending')
                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                        Pending
                    </span>
                @elseif($order->payment_status === 'cancelled')
                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                        Dibatalkan
                    </span>
                @else
                    <span class="px-2 py-1 text-xs bg-slate-50 text-slate-600 rounded-full">
                        {{ $order->payment_status ?? '-' }}
                    </span>
                @endif
            </td>

            {{-- Operational Status --}}
            <td class="px-6 py-4 border-b border-slate-50 text-sm">
                @if($order->status === 'cancelled')
                    <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                        Dibatalkan
                    </span>
                @elseif($order->checked_out_at)
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                        Selesai
                    </span>
                @elseif($order->checked_in_at)
                    <span class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">
                        Check-in
                    </span>
                @elseif($order->check_in && $order->check_in->isFuture())
                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                        Akan Datang
                    </span>
                @else
                    <span class="px-2 py-1 text-xs bg-slate-50 text-slate-600 rounded-full">
                        Menunggu
                    </span>
                @endif
            </td>

            <td class="px-6 py-4 border-b border-slate-50 text-sm">
                @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                    <form method="POST"
                          action="{{ route('admin.orders.checkin', $order) }}"
                          class="inline">
                        @csrf
                        <button class="text-indigo-600 hover:underline text-xs font-medium">
                            Check In
                        </button>
                    </form>
                @endif

                @if($order->checked_in_at && !$order->checked_out_at)
                    <form method="POST"
                          action="{{ route('admin.orders.checkout', $order) }}"
                          class="inline">
                        @csrf
                        <button class="text-green-600 hover:underline text-xs font-medium">
                            Check Out
                        </button>
                    </form>
                @endif

                @if($order->checked_out_at)
                    <span class="text-xs text-slate-500">Selesai</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="p-6 text-center text-slate-500">
                Tidak ada data pesanan
            </td>
        </tr>
    @endforelse
    </tbody>
</table>
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection
