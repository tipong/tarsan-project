<form method="POST" action="{{ route('resepsionis.orders.store') }}">
@csrf

<input name="guest_name" placeholder="Guest Name" required>
<input name="guest_phone" placeholder="Phone">

<select name="room_id">
@foreach($rooms as $room)
    <option value="{{ $room->id }}">{{ $room->room_name }}</option>
@endforeach
</select>

<input type="date" name="check_in_date" required>
<input type="date" name="check_out_date" required>

<button>Save Order</button>
</form>