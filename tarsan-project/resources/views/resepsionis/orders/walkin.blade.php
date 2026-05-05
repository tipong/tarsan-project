@extends('resepsionis.layouts.app')

@section('title', 'Walk-in Booking')

@section('content')
<h1 class="text-xl font-semibold mb-4">Walk-in Booking</h1>

<form method="POST"
      action="{{ route('resepsionis.orders.walkin.store') }}"
      class="bg-white p-6 rounded shadow max-w-xl space-y-4">
@csrf

<input
    name="guest_name"
    placeholder="Nama Tamu"
    class="w-full border rounded px-3 py-2"
    required>

<input
    name="guest_phone"
    placeholder="No. Telepon"
    class="w-full border rounded px-3 py-2"
    required>

<select name="room_id" class="w-full border rounded px-3 py-2" required>
    <option value="">Pilih Kamar</option>
    @foreach($rooms as $room)
        <option value="{{ $room->id }}">
            {{ $room->room_name }} — Rp {{ number_format($room->price_per_night) }}/malam
        </option>
    @endforeach
</select>

<div class="grid grid-cols-2 gap-4">
    <input type="date" name="check_in_date" required class="border rounded px-3 py-2">
    <input type="date" name="check_out_date" required class="border rounded px-3 py-2">
</div>

<button class="bg-blue-600 text-white px-6 py-2 rounded">
    Simpan & Check-in
</button>

</form>
@endsection