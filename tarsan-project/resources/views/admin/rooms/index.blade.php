@extends('admin.layouts.app')

@section('title', 'Rooms')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-xl font-semibold">Rooms</h1>

    <a href="{{ route('admin.rooms.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Room
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Room</th>
                <th>Price</th>
                <th>Capacity</th>
                <th>Available</th>
                <th>Status</th>
                <th class="p-3">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($rooms as $room)
            <tr class="border-t align-top">
                {{-- ROOM + IMAGE --}}
                <td class="p-3">
                    <div class="flex gap-3 items-start">

                        {{-- IMAGE / SLIDER --}}
                        <div class="w-24 h-16 rounded overflow-hidden bg-gray-100"
                             x-data="{ index: 0 }">

                            @if($room->images->count() > 0)
                                <img
                                    :src="`{{ asset('storage') }}/` + {{ $room->images->pluck('image') }}[index]"
                                    class="w-full h-full object-cover">

                                @if($room->images->count() > 1)
                                    <div class="flex justify-between absolute w-24 -mt-10 px-1">
                                        <button @click="index = (index - 1 + {{ $room->images->count() }}) % {{ $room->images->count() }}"
                                                class="bg-black/40 text-white px-1 rounded">
                                            ‹
                                        </button>
                                        <button @click="index = (index + 1) % {{ $room->images->count() }}"
                                                class="bg-black/40 text-white px-1 rounded">
                                            ›
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">
                                    No Image
                                </div>
                            @endif
                        </div>

                        {{-- NAME --}}
                        <div>
                            <div class="font-semibold">{{ $room->room_name }}</div>
                            <div class="text-xs text-gray-500">
                                {{ Str::limit($room->description, 50) }}
                            </div>
                        </div>
                    </div>
                </td>

                <td>Rp {{ number_format($room->price_per_night) }} / night</td>
                <td>{{ $room->capacity }} pax</td>
                <td>
                    @if($room->available_rooms > 0)
                        <span class="text-green-600">
                            {{ $room->available_rooms }} available
                        </span>
                    @else
                        <span class="text-red-600">
                            Full
                        </span>
                    @endif
                </td>

                <td>
                    <span class="{{ $room->is_active ? 'text-green-600' : 'text-red-600' }}">
                        {{ $room->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>

                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.rooms.edit', $room) }}"
                       class="text-blue-600 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.rooms.destroy', $room) }}"
                          onsubmit="return confirm('Hapus kamar ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    Belum ada kamar
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
