@extends('resepsionis.layouts.app')

@section('title', 'Availability Kamar')

@section('content')
<h1 class="text-xl font-semibold mb-4">Cek Availability Kamar</h1>

<form method="POST"
      action="{{ route('resepsionis.availability.check') }}"
      class="bg-white p-4 rounded shadow mb-6 flex gap-4 items-end">
@csrf

<div>
    <label class="text-sm text-gray-600">Check-in</label>
    <input type="date" name="check_in" required
           value="{{ $checkIn ?? '' }}"
           class="border rounded px-3 py-2">
</div>

<div>
    <label class="text-sm text-gray-600">Check-out</label>
    <input type="date" name="check_out" required
           value="{{ $checkOut ?? '' }}"
           class="border rounded px-3 py-2">
</div>

<button class="bg-blue-600 text-white px-6 py-2 rounded">
    Cek
</button>
</form>

@if(isset($rooms))
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Kamar</th>
            <th>Harga</th>
            <th>Status</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $data)
        <tr class="border-t">
            <td class="p-3">{{ $data['room']->room_name }}</td>
            <td>Rp {{ number_format($data['room']->price_per_night) }}</td>
            <td>
                @if($data['available'])
                    <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                        Available
                    </span>
                @else
                    <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                        Not Available
                    </span>
                @endif
            </td>
            <td class="p-3">
                @if($data['available'])
                    <a href="{{ route('resepsionis.orders.walkin.create', [
                        'room_id' => $data['room']->id,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut
                    ]) }}"
                       class="text-blue-600 hover:underline">
                        Walk-in Booking
                    </a>
                @else
                    —
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endif
@endsection