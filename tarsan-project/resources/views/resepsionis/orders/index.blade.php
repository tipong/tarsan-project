@extends('resepsionis.layouts.app')

@section('title', 'Orders')

@section('content')
<h1 class="text-xl font-semibold mb-4">Daftar Pesanan</h1>

<table class="w-full bg-white rounded shadow text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Tamu</th>
            <th>Kamar</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-3">{{ $order->user->name }}</td>
            <td>{{ $order->room->room_name }}</td>
            <td>{{ $order->check_in_date->format('d M Y') }}</td>
            <td>{{ $order->check_out_date->format('d M Y') }}</td>
            <td>{{ $order->operational_status }}</td>
            <td class="p-3 flex gap-2">
                @if(!$order->checked_in_at)
                    <form method="POST" action="{{ route('resepsionis.orders.checkin', $order) }}">
                        @csrf
                        <button class="text-green-600">Check-in</button>
                    </form>
                @elseif(!$order->checked_out_at)
                    <form method="POST" action="{{ route('resepsionis.orders.checkout', $order) }}">
                        @csrf
                        <button class="text-red-600">Check-out</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection