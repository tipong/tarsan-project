@extends('admin.layouts.app')

@section('title', 'Rooms')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Rooms</h1>

    <a href="{{ route('admin.rooms.create') }}"
       class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-md text-sm font-medium">
        + Add Room
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Capacity</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Available</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($rooms as $room)
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 border-b border-slate-50 text-sm">
                    <div class="flex items-center gap-3">
                        @if($room->images->first())
                            <img src="{{ asset('storage/' . $room->images->first()->image) }}"
                                 class="w-16 h-12 rounded-xl object-cover"
                                 alt="{{ $room->room_name }}">
                        @else
                            <div class="w-16 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500 text-xs">
                                No Image
                            </div>
                        @endif
                        <div>
                            <div class="font-medium">{{ $room->room_name }}</div>
                            <div class="text-xs text-slate-500">{{ Str::limit($room->description, 40) }}</div>
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 border-b border-slate-50 text-sm">Rp {{ number_format($room->price_per_night) }} / night</td>
                <td class="px-6 py-4 border-b border-slate-50 text-sm">{{ $room->capacity }} pax</td>
                <td class="px-6 py-4 border-b border-slate-50 text-sm">
                    @if($room->available_rooms > 0)
                        <span class="text-green-600">{{ $room->available_rooms }} available</span>
                    @else
                        <span class="text-red-600">Full</span>
                    @endif
                </td>

                <td class="px-6 py-4 border-b border-slate-50 text-sm">
                    <span class="px-2 py-1 text-xs rounded-full {{ $room->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-50 text-slate-600' }}">
                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td class="px-6 py-4 border-b border-slate-50 text-sm">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.rooms.edit', $room) }}"
                           class="text-indigo-600 hover:underline text-xs font-medium">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.rooms.destroy', $room) }}"
                              onsubmit="return confirm('Hapus kamar ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs font-medium">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-slate-500">
                    Belum ada kamar
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
