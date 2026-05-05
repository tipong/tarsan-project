@extends('admin.layouts.app')

@section('title', 'Edit Room')

@section('content')
<form method="POST"
      action="{{ route('admin.rooms.update', $room) }}"
      class="bg-white p-6 rounded shadow max-w-xl"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="space-y-4">

    {{-- ROOM NAME --}}
    <input
        name="room_name"
        value="{{ old('room_name', $room->room_name) }}"
        class="w-full border rounded p-2"
        required>

    {{-- PRICE --}}
    <input
        type="number"
        name="price_per_night"
        value="{{ old('price_per_night', $room->price_per_night) }}"
        class="w-full border rounded p-2"
        required>

    {{-- CAPACITY --}}
    <input
        type="number"
        name="capacity"
        value="{{ old('capacity', $room->capacity) }}"
        class="w-full border rounded p-2"
        required>

    {{-- TOTAL ROOMS --}}
    <input
        type="number"
        name="total_rooms"
        value="{{ old('total_rooms', $room->total_rooms) }}"
        class="w-full border rounded p-2"
        required>

    {{-- FACILITIES --}}
    <textarea
        name="facilities"
        class="w-full border rounded p-2"
        placeholder="Facilities">{{ old('facilities', $room->facilities) }}</textarea>

    {{-- DESCRIPTION --}}
    <textarea
        name="description"
        class="w-full border rounded p-2"
        placeholder="Description">{{ old('description', $room->description) }}</textarea>

    {{-- ACTIVE --}}
    <label class="flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1"
               {{ old('is_active', $room->is_active) ? 'checked' : '' }}>
        Active
    </label>

    {{-- EXISTING IMAGES --}}
    <div>
        <p class="font-semibold mb-2">Existing Images</p>

        @if($room->images->count())
            <div class="grid grid-cols-3 gap-4">
                @foreach($room->images as $image)
                    <label class="relative cursor-pointer group">

                        {{-- CHECKBOX --}}
                        <input
                            type="checkbox"
                            name="delete_images[]"
                            value="{{ $image->id }}"
                            class="absolute top-2 left-2 w-4 h-4 z-10 accent-red-600">

                        {{-- IMAGE --}}
                        <img
                            src="{{ asset('storage/' . $image->image) }}"
                            class="w-full h-28 object-cover rounded border
                                group-hover:opacity-80 transition">

                        {{-- OVERLAY TEXT --}}
                        <span class="absolute bottom-1 left-1 bg-black/60 text-white text-xs px-2 py-1 rounded">
                            Hapus
                        </span>
                    </label>
                @endforeach
            </div>

            <p class="text-xs text-gray-500 mt-2">
                ✔ Centang gambar yang ingin dihapus
            </p>
        @else
            <p class="text-sm text-gray-400">No images uploaded.</p>
        @endif
    </div>


    {{-- ADD NEW IMAGES --}}
    <div>
        <p class="font-semibold mb-1">Add New Images</p>
        <input type="file"
               name="images[]"
               multiple
               accept="image/*"
               class="w-full border rounded p-2">
    </div>

    {{-- SUBMIT --}}
    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

</div>
</form>
@endsection
