@extends('admin.layouts.app')

@section('title', 'Manage Vouchers')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Discount Vouchers</h1>
        <p class="text-slate-500 mt-1">Create and manage promotional codes for guests</p>
    </div>
    <button onclick="openVoucherModal('add')"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition duration-200 font-bold text-sm shadow-lg shadow-indigo-100">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Add Voucher
    </button>
</div>

{{-- FILTER SECTION --}}
<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Voucher Status</label>
            <select name="status" class="bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all min-w-[180px]">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected' : '' }}>Active</option>
                <option value="scheduled" {{ request('status')=='scheduled'?'selected' : '' }}>Scheduled</option>
                <option value="expired" {{ request('status')=='expired'?'selected' : '' }}>Expired</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition font-bold text-sm shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.vouchers.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold text-sm">
                Reset
            </a>
        </div>
    </form>
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Potongan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Masa Berlaku</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($vouchers as $voucher)
                    <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl font-mono font-black text-sm border-2 border-dashed border-indigo-200 uppercase tracking-wider shadow-sm group-hover:bg-indigo-100/50 transition-colors duration-200">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                                {{ $voucher->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($voucher->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2.5">
                                <div class="p-1.5 rounded-lg bg-slate-50 text-slate-400 shrink-0">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700">{{ $voucher->starts_at->format('d M Y') }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium mt-0.5">s/d {{ $voucher->ends_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($voucher->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">Active</span>
                            @elseif($voucher->status === 'scheduled')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">Scheduled</span>
                            @elseif($voucher->status === 'expired')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-400 border border-slate-200">Expired</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-100">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button onclick="openVoucherModal('edit', {{ json_encode($voucher) }})"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-200 hover:shadow-sm" title="Edit">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus voucher ini?')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">No discount vouchers added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MOBILE CARD VIEW --}}
<div class="md:hidden space-y-3">
    @forelse($vouchers as $voucher)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <div class="flex items-start justify-between mb-3">
                <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg font-mono font-black text-sm border border-indigo-100 uppercase">
                    {{ $voucher->code }}
                </span>
                @if($voucher->status === 'active')
                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase">Active</span>
                @elseif($voucher->status === 'scheduled')
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase">Scheduled</span>
                @elseif($voucher->status === 'expired')
                    <span class="px-2 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-black uppercase">Expired</span>
                @else
                    <span class="px-2 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase">Inactive</span>
                @endif
            </div>
            <div class="bg-slate-50 rounded-xl p-3 mb-3 space-y-1.5">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Potongan</span>
                    <span class="text-sm font-bold text-slate-900">Rp {{ number_format($voucher->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Berlaku</span>
                    <span class="text-xs font-bold text-slate-700">{{ $voucher->starts_at->format('d M') }} - {{ $voucher->ends_at->format('d M Y') }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="openVoucherModal('edit', {{ json_encode($voucher) }})"
                        class="flex-1 py-2.5 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition font-bold text-xs text-center">
                    Edit
                </button>
                <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this voucher?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition font-bold text-xs text-center">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
            <p class="text-slate-400 italic">No discount vouchers added yet.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $vouchers->links() }}
</div>

{{-- VOUCHER MODAL --}}
<div id="voucherModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="voucherModalContent">
        <div class="p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 id="voucherModalTitle" class="text-2xl font-black text-slate-900">Add Voucher</h2>
                <button onclick="closeVoucherModal()" class="p-2 hover:bg-slate-50 rounded-full transition duration-200 text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="voucherForm" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="_method" id="voucherMethod" value="POST">

                {{-- Code --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Kode Voucher</label>
                    <input type="text" name="code" id="voucherCode" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-black placeholder-slate-400 outline-none transition-all uppercase"
                           placeholder="CONTOH: PROMO2024">
                </div>

                {{-- Amount --}}
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Nominal Potongan (Rp)</label>
                    <input type="number" name="amount" id="voucherAmount" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-600 text-slate-900 font-bold placeholder-slate-400 outline-none transition-all"
                           placeholder="0">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Starts At --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Start Date</label>
                        <input type="datetime-local" name="starts_at" id="voucherStarts" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-indigo-600 text-xs text-slate-900 font-medium outline-none transition-all">
                    </div>

                    {{-- Ends At --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">End Date</label>
                        <input type="datetime-local" name="ends_at" id="voucherEnds" required
                               class="w-full bg-slate-50 border-none rounded-2xl px-4 py-4 focus:ring-2 focus:ring-indigo-600 text-xs text-slate-900 font-medium outline-none transition-all">
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="flex items-center gap-3 cursor-pointer p-4 bg-slate-50 rounded-2xl">
                        <input type="checkbox" name="is_active" id="voucherIsActive" value="1"
                               class="rounded-lg border-slate-200 text-indigo-600 focus:ring-indigo-600">
                        <span class="text-sm font-bold text-slate-700 uppercase tracking-widest">Voucher Aktif</span>
                    </label>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="closeVoucherModal()"
                            class="flex-1 px-6 py-4 border border-slate-200 text-slate-600 rounded-2xl hover:bg-slate-50 transition font-bold text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition shadow-xl font-bold text-sm">
                        Save Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openVoucherModal(mode, voucher = null) {
        const modal = document.getElementById('voucherModal');
        const content = document.getElementById('voucherModalContent');
        const form = document.getElementById('voucherForm');
        const title = document.getElementById('voucherModalTitle');
        const methodInput = document.getElementById('voucherMethod');
        const codeInput = document.getElementById('voucherCode');
        const amountInput = document.getElementById('voucherAmount');
        const startsInput = document.getElementById('voucherStarts');
        const endsInput = document.getElementById('voucherEnds');
        const activeInput = document.getElementById('voucherIsActive');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
        }, 10);

        if (mode === 'add') {
            title.innerText = 'Add Voucher';
            form.action = "{{ route('admin.vouchers.store') }}";
            methodInput.value = 'POST';
            codeInput.value = '';
            amountInput.value = '';
            startsInput.value = '';
            endsInput.value = '';
            activeInput.checked = true;
        } else {
            title.innerText = 'Edit Voucher';
            form.action = `/admin/vouchers/${voucher.id}`;
            methodInput.value = 'PUT';
            codeInput.value = voucher.code;
            amountInput.value = voucher.amount;

            // Format dates for datetime-local input
            if(voucher.starts_at) {
                const start = new Date(voucher.starts_at);
                startsInput.value = start.toISOString().slice(0, 16);
            }
            if(voucher.ends_at) {
                const end = new Date(voucher.ends_at);
                endsInput.value = end.toISOString().slice(0, 16);
            }

            activeInput.checked = voucher.is_active;
        }
    }

    function closeVoucherModal() {
        const modal = document.getElementById('voucherModal');
        const content = document.getElementById('voucherModalContent');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
