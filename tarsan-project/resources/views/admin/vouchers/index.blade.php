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

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Kode</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Potongan</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider text-[10px]">Masa Berlaku</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider text-[10px]">Status</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider text-[10px]">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($vouchers as $voucher)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg font-mono font-black text-sm border border-indigo-100 uppercase">
                                {{ $voucher->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-900">Rp {{ number_format($voucher->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">{{ $voucher->starts_at->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">s/d {{ $voucher->ends_at->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($voucher->status === 'active')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Active</span>
                            @elseif($voucher->status === 'scheduled')
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Scheduled</span>
                            @elseif($voucher->status === 'expired')
                                <span class="px-2 py-1 bg-slate-100 text-slate-400 rounded-lg text-[10px] font-black uppercase tracking-tighter">Expired</span>
                            @else
                                <span class="px-2 py-1 bg-red-50 text-red-600 rounded-lg text-[10px] font-black uppercase tracking-tighter">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openVoucherModal('edit', {{ json_encode($voucher) }})"
                                        class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-xl transition duration-200" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.vouchers.destroy', $voucher) }}" method="POST" class="inline" onsubmit="return confirm('Delete this voucher?')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">No discount vouchers added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
