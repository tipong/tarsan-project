@extends('admin.layouts.app')

@section('title', 'Add Room')

@section('content')
<div class="max-w-xl">

    {{-- ERROR VALIDATION --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.rooms.store') }}"
          enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow">

        @csrf

        <div class="space-y-4">

            <input name="room_name"
                   value="{{ old('room_name') }}"
                   placeholder="Room Name"
                   class="w-full border rounded p-2"
                   required>

            <input type="file"
                   name="images[]"
                   multiple
                   accept="image/*"
                   class="w-full border rounded p-2">

            <input type="number"
                   name="price_per_night"
                   value="{{ old('price_per_night') }}"
                   placeholder="Price per Night"
                   class="w-full border rounded p-2"
                   required>

            <input type="number"
                   name="capacity"
                   value="{{ old('capacity') }}"
                   placeholder="Capacity"
                   class="w-full border rounded p-2"
                   required>

            <input type="number"
                   name="total_rooms"
                   value="{{ old('total_rooms') }}"
                   placeholder="Total Rooms"
                   class="w-full border rounded p-2"
                   required>

            <textarea name="facilities"
                      placeholder="Facilities"
                      class="w-full border rounded p-2">{{ old('facilities') }}</textarea>

            <textarea name="description"
                      placeholder="Description"
                      class="w-full border rounded p-2">{{ old('description') }}</textarea>

            <label class="flex items-center gap-2">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}>
                Active
            </label>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save
            </button>

        </div>
    </form>
</div>
@endsection
