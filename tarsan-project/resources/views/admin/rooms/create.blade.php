@extends('admin.layouts.app')

@section('title', 'Add Room')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-xl font-semibold mb-4">Add Room</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
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
          class="bg-white p-6 rounded-xl shadow">

        @csrf

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Room Name</label>
                <input name="room_name"
                       value="{{ old('room_name') }}"
                       placeholder="Room Name"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Images</label>
                <input type="file"
                       name="images[]"
                       multiple
                       accept="image/*"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:bg-indigo-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-slate-500">Upload multiple images (JPG, PNG, max 2MB each)</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Price per Night</label>
                    <input type="number"
                           name="price_per_night"
                           value="{{ old('price_per_night') }}"
                           placeholder="Price per Night"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Capacity</label>
                    <input type="number"
                           name="capacity"
                           value="{{ old('capacity') }}"
                           placeholder="Capacity"
                           class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                           required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Total Rooms</label>
                <input type="number"
                       name="total_rooms"
                       value="{{ old('total_rooms') }}"
                       placeholder="Total Rooms"
                       class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Facilities</label>
                @if($usesFacilityRelations)
                    <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border rounded-xl p-3">
                        @foreach($facilities as $facility)
                            <label class="flex items-center gap-2 p-2 hover:bg-slate-50 rounded">
                                <input type="checkbox"
                                       name="facility_ids[]"
                                       value="{{ $facility->id }}"
                                       {{ in_array($facility->id, old('facility_ids', [])) ? 'checked' : '' }}
                                       class="rounded-xl border-slate-200 text-indigo-600 focus:ring-indigo-600">
                                <span class="text-sm">{{ $facility->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <textarea name="facilities"
                              rows="3"
                              placeholder="Example: AC, Shower, WiFi, Private Bathroom"
                              class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all">{{ old('facilities') }}</textarea>
                    <p class="mt-1 text-xs text-slate-500">Separate facilities with comma</p>
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Description</label>
                <textarea name="description"
                          rows="4"
                          placeholder="Description"
                          class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded-xl border-slate-200 text-indigo-600 focus:ring-indigo-600">
                    <span class="text-sm font-medium text-slate-700">Active</span>
                </label>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm font-medium-xl hover:bg-slate-800">
                    Save
                </button>
                <a href="{{ route('admin.rooms.index') }}" class="text-slate-600 hover:underline">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
