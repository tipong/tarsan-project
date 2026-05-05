@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')

<h1 class="text-xl font-semibold mb-4">Orders</h1>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
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
        class="border rounded px-3 py-2">

    {{-- STATUS --}}
    <select name="status" class="border rounded px-3 py-2 w-40">
        <option value="">All Status</option>
        <option value="upcoming" {{ request('status')=='upcoming'?'selected':'' }}>
            Upcoming
        </option>
        <option value="ongoing" {{ request('status')=='ongoing'?'selected':'' }}>
            Ongoing
        </option>
        <option value="completed" {{ request('status')=='completed'?'selected':'' }}>
            Completed
        </option>
        <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>
            Cancelled
        </option>
    </select>

    {{-- DATE --}}
    <input
        type="date"
        name="date"
        value="{{ request('date') }}"
        class="border rounded px-3 py-2">

    {{-- ROOM --}}
    <select name="room_id" class="border rounded px-3 py-2 w-48">
        <option value="">All Rooms</option>
        @foreach($rooms as $room)
            <option value="{{ $room->id }}"
                {{ request('room_id')==$room->id?'selected':'' }}>
                {{ $room->room_name }}
            </option>
        @endforeach
    </select>

    {{-- BUTTON --}}
    <button class="bg-blue-600 text-white px-6 py-2 rounded">
        Filter
    </button>

    <a href="{{ route('admin.orders.index') }}"
       class="px-4 py-2 border rounded">
        Reset
    </a>
</form>

<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Guest</th>
            <th>Room</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Status</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
    @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-3">{{ $order->user->name }}</td>
            <td>{{ $order->room->room_name }}</td>
            <td>{{ $order->check_in_date->format('d M Y H:i') }}</td>
            <td>{{ $order->check_out_date->format('d M Y H:i') }}</td>

            <td>
                @switch($order->operational_status)
                    @case('upcoming')
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">
                            Upcoming
                        </span>
                        @break

                    @case('ongoing')
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                            Ongoing
                        </span>
                        @break

                    @case('completed')
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                            Completed
                        </span>
                        @break

                    @default
                        <span class="px-2 py-1 text-xs bg-gray-200 text-gray-600 rounded">
                            Cancelled
                        </span>
                @endswitch
            </td>



            <td class="p-3 flex gap-2">
                @if(!$order->checked_in_at)
                    <form method="POST"
                          action="{{ route('admin.orders.checkin', $order) }}">
                        @csrf
                        <button class="text-blue-600 hover:underline">
                            Check In
                        </button>
                    </form>
                @endif

                @if($order->checked_in_at && !$order->checked_out_at)
                    <form method="POST"
                          action="{{ route('admin.orders.checkout', $order) }}">
                        @csrf
                        <button class="text-green-600 hover:underline">
                            Check Out
                        </button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>

@endsection
