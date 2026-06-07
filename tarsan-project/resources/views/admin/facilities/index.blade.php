@extends('admin.layouts.app')

@section('title', 'Manage Facilities')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Homestay Facilities</h1>
            <p class="text-slate-500 mt-1">Manage available facilities for each room</p>
        </div>
        <button onclick="openFacilityModal('add')"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition duration-200 font-bold text-sm shadow-lg shadow-indigo-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Facility
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

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Fasilitas</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($facilities as $facility)
                        <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm group-hover:scale-105 transition-transform duration-200 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-200">{{ $facility->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $facility->slug }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="openFacilityModal('edit', {{ json_encode($facility) }})"
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-200 hover:shadow-sm"
                                            title="Edit">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition duration-200 hover:shadow-sm" title="Delete">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 font-medium italic text-sm">Belum ada fasilitas yang ditambahkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MOBILE CARD VIEW --}}
    <div class="md:hidden space-y-3">
        @forelse($facilities as $facility)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $facility->name }}</p>
                        <p class="text-[10px] text-slate-400 font-mono tracking-tight">{{ $facility->slug }}</p>
                    </div>
                </div>
                <div class="flex gap-1.5 shrink-0">
                    <button onclick="openFacilityModal('edit', {{ json_encode($facility) }})"
                            class="p-2 text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/50 rounded-xl transition duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-600 bg-rose-50/50 hover:bg-rose-100/50 rounded-xl transition duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-2xl border border-dashed border-slate-200">
                <p class="text-slate-400 italic text-sm">Belum ada fasilitas yang ditambahkan.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- MODAL --}}
<div id="facilityModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="facilityModalContent">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 id="facilityModalTitle" class="text-2xl font-black text-slate-900">Add Facility</h2>
                <button onclick="closeFacilityModal()" class="p-2 hover:bg-slate-50 rounded-full transition duration-200 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="facilityForm" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="facilityMethod" value="POST">

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">Facility Name</label>
                    <input type="text" name="name" id="facilityName" required
                           class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 focus:ring-2 focus:ring-indigo-600 focus:border-indigo-600 text-slate-900 font-medium placeholder-slate-400 outline-none transition-all shadow-sm"
                           placeholder="Example: Fast WiFi, Swimming Pool, Air Conditioning">
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeFacilityModal()"
                            class="flex-1 px-6 py-4 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition font-bold text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition shadow-xl font-bold text-sm">
                        Save Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openFacilityModal(mode, facility = null) {
        const modal = document.getElementById('facilityModal');
        const content = document.getElementById('facilityModalContent');
        const form = document.getElementById('facilityForm');
        const title = document.getElementById('facilityModalTitle');
        const nameInput = document.getElementById('facilityName');
        const methodInput = document.getElementById('facilityMethod');

        // Display modal
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 10);

        if (mode === 'add') {
            title.innerText = 'Add Facility';
            form.action = "{{ route('admin.facilities.store') }}";
            methodInput.value = 'POST';
            nameInput.value = '';
        } else if (mode === 'edit' && facility) {
            title.innerText = 'Edit Facility';
            form.action = "{{ url('admin/facilities') }}/" + facility.id;
            methodInput.value = 'PUT';
            nameInput.value = facility.name;
        }
    }

    function closeFacilityModal() {
        const modal = document.getElementById('facilityModal');
        const content = document.getElementById('facilityModalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Close when pressing ESC
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeFacilityModal();
    });

    // Close when clicking outside modal
    document.getElementById('facilityModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeFacilityModal();
    });
</script>

@endsection
