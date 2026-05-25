@extends('admin.layouts.app')

@section('title', 'Manage Rooms')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Room List</h1>
        <p class="text-slate-500 mt-1">Manage room types, prices, and availability</p>
    </div>
    <button onclick="openRoomModal('add')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition duration-200 font-bold text-sm shadow-lg shadow-indigo-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Room
    </button>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl animate-in fade-in slide-in-from-top-4">
        <div class="flex items-center gap-3 mb-2">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-sm">Ada kesalahan input:</span>
        </div>
        <ul class="list-disc pl-8 text-xs space-y-1 font-medium text-rose-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Room</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Price</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Capacity</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Available</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Status</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($rooms as $room)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative group">
                                    @if($room->images->first())
                                        <img src="{{ image_url($room->images->first()->image) }}"
                                             class="w-16 h-12 rounded-xl object-cover shadow-sm group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-16 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] font-bold uppercase">
                                            No Img
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900">{{ $room->room_name }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ Str::limit($room->description, 30) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-indigo-600">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-slate-400 block font-medium">/ night</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold">
                                {{ $room->capacity }} Pax
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold {{ $room->available_rooms > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $room->available_rooms }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($room->is_active)
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase">Active</span>
                            @else
                                <span class="px-2 py-1 bg-slate-50 text-slate-400 rounded-lg text-[10px] font-black uppercase">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openRoomModal('edit', {{ json_encode($room) }})"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition duration-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline" onsubmit="return confirm('Delete this room?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition duration-200" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 italic">No rooms available yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ROOM MODAL --}}
<div id="roomModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-2xl shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="roomModalContent">
        <div class="p-8 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-8 sticky top-0 bg-white z-10 pb-4">
                <h2 id="roomModalTitle" class="text-2xl font-black text-slate-900">Add Room</h2>
                <button onclick="closeRoomModal()" class="p-2 hover:bg-slate-50 rounded-full transition duration-200 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="roomForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="roomMethod" value="POST">

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Nama Kamar --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nama Kamar</label>
                        <input type="text" name="room_name" id="roomName" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                               placeholder="Contoh: Deluxe Suite">
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Harga per Malam</label>
                        <div class="relative">
                            <span class="absolute left-5 top-4 text-slate-400 font-bold">Rp</span>
                            <input type="number" name="price_per_night" id="roomPrice" required
                                   class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                                   placeholder="0">
                        </div>
                    </div>

                    {{-- Kapasitas --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Kapasitas (Pax)</label>
                        <input type="number" name="capacity" id="roomCapacity" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                               placeholder="0">
                    </div>

                    {{-- Total Kamar --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Total Kamar</label>
                        <input type="number" name="total_rooms" id="roomTotal" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                               placeholder="0">
                    </div>
                </div>

                {{-- Images --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Foto Kamar (Multiple)</label>
                    <div id="editImagesContainer" class="hidden mb-4 grid grid-cols-4 gap-4">
                        {{-- Existing images will be loaded here --}}
                    </div>
                    <input type="file" name="images[]" multiple accept="image/*"
                           class="w-full bg-slate-50 border-dashed border-2 border-slate-200 rounded-2xl px-5 py-8 text-center text-sm text-slate-400 cursor-pointer hover:border-indigo-400 transition-all">
                    <p class="mt-2 text-[10px] text-slate-400 font-medium">You can select multiple images. Format JPG/PNG max 5MB.</p>
                </div>

                {{-- Facilities --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Fasilitas</label>
                    @if($usesFacilityRelations)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 bg-slate-50 p-6 rounded-3xl max-h-48 overflow-y-auto">
                            @foreach($facilities as $facility)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="facility_ids[]" value="{{ $facility->id }}"
                                           class="facility-checkbox rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-600 transition duration-200">
                                    <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600 transition">{{ $facility->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <textarea name="facilities" id="roomLegacyFacilities" rows="2"
                                  class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                                  placeholder="Separate with comma: AC, WiFi, TV"></textarea>
                    @endif
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Description</label>
                    <textarea name="description" id="roomDescription" rows="4"
                              class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all"
                              placeholder="Ceritakan tentang kamar ini..."></textarea>
                </div>

                {{-- Status --}}
                <div>
                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-slate-50 rounded-2xl">
                        <input type="checkbox" name="is_active" id="roomIsActive" value="1"
                               class="rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-600">
                        <span class="text-sm font-bold text-slate-700 uppercase tracking-widest">Room Active & Bookable</span>
                    </label>
                </div>

                {{-- Action --}}
                <div class="flex gap-4 pt-6 pb-2">
                    <button type="button" onclick="closeRoomModal()"
                            class="flex-1 px-6 py-4 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition font-bold text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition shadow-xl font-bold text-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRoomModal(mode, room = null) {
        const modal = document.getElementById('roomModal');
        const content = document.getElementById('roomModalContent');
        const form = document.getElementById('roomForm');
        const title = document.getElementById('roomModalTitle');
        const methodInput = document.getElementById('roomMethod');
        const nameInput = document.getElementById('roomName');
        const priceInput = document.getElementById('roomPrice');
        const capacityInput = document.getElementById('roomCapacity');
        const totalInput = document.getElementById('roomTotal');
        const descInput = document.getElementById('roomDescription');
        const activeInput = document.getElementById('roomIsActive');
        const legacyFacilities = document.getElementById('roomLegacyFacilities');
        const imagesContainer = document.getElementById('editImagesContainer');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 10);

        // Reset facilities
        document.querySelectorAll('.facility-checkbox').forEach(cb => cb.checked = false);
        imagesContainer.innerHTML = '';
        imagesContainer.classList.add('hidden');

        if (mode === 'add') {
            title.innerText = 'Add Room';
            form.action = "{{ route('admin.rooms.store') }}";
            methodInput.value = 'POST';
            nameInput.value = '';
            priceInput.value = '';
            capacityInput.value = '';
            totalInput.value = '';
            descInput.value = '';
            activeInput.checked = true;
            if(legacyFacilities) legacyFacilities.value = '';
        } else {
            title.innerText = 'Edit Room';
            form.action = `/admin/rooms/${room.id}`;
            methodInput.value = 'POST';
            nameInput.value = room.room_name;
            priceInput.value = room.price_per_night;
            capacityInput.value = room.capacity;
            totalInput.value = room.total_rooms;
            descInput.value = room.description || '';
            activeInput.checked = room.is_active;

            if(legacyFacilities) legacyFacilities.value = room.facilities || '';

            // Set facilities
            if(room.facilities && Array.isArray(room.facilities)) {
                const facilityIds = room.facilities.map(f => f.id);
                document.querySelectorAll('.facility-checkbox').forEach(cb => {
                    if(facilityIds.includes(parseInt(cb.value))) cb.checked = true;
                });
            }

            // Show images if any
            if(room.images && room.images.length > 0) {
                imagesContainer.classList.remove('hidden');
                room.images.forEach(img => {
                    const label = document.createElement('label');
                    label.className = 'relative group aspect-square rounded-xl overflow-hidden cursor-pointer block border';
                    label.innerHTML = `
                        <input type="checkbox" name="delete_images[]" value="${img.id}" class="hidden peer">
                        <img src="${img.image.startsWith('http') ? img.image : '/storage/' + img.image}" class="w-full h-full object-cover peer-checked:opacity-40 transition duration-200">
                        <div class="absolute inset-0 bg-red-600/40 opacity-0 peer-checked:opacity-100 transition duration-200 flex items-center justify-center">
                            <span class="bg-red-600 text-white px-2 py-1 rounded-lg text-[8px] font-black uppercase shadow">DELETING</span>
                        </div>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 peer-checked:hidden transition duration-200 flex items-center justify-center">
                            <span class="bg-white text-red-600 px-2 py-1 rounded-lg text-[8px] font-black uppercase shadow">MARK DELETE</span>
                        </div>
                    `;
                    imagesContainer.appendChild(label);
                });
            }
        }
    }

    function closeRoomModal() {
        const modal = document.getElementById('roomModal');
        const content = document.getElementById('roomModalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>
@endsection
