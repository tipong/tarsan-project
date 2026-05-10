@extends('admin.layouts.app')

@section('title', 'Add Voucher')

@section('content')
<div class="max-w-xl">

    <form method="POST" action="{{ route('admin.vouchers.store') }}" class="bg-white p-6 rounded-xl shadow max-w-xl">
    @csrf

    <div class="space-y-6">

        <label for="code" class="block text-sm font-medium text-slate-800 font-semibold mb-2">Voucher Code</label>
        <input
            type="text"
            name="code"
            id="code"
            placeholder="Enter voucher code"
            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800"
            required>

        <label for="amount" class="block text-sm font-medium text-slate-800 font-semibold mb-2">Nominal (Rp)</label>
        <input
            type="number"
            name="amount"
            id="amount"
            placeholder="Enter voucher amount"
            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800"
            required>

        <label for="starts_at" class="block text-sm font-medium text-slate-800 font-semibold mb-2">Start Time</label>
        <input
            type="datetime-local"
            name="starts_at"
            id="starts_at"
            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800"
            required>

        <label for="ends_at" class="block text-sm font-medium text-slate-800 font-semibold mb-2">End Time</label>
        <input
            type="datetime-local"
            name="ends_at"
            id="ends_at"
            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800"
            required>

        <button type="submit" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-sm text-sm font-medium-xl hover:bg-slate-800">Save Voucher</button>
    </div>
</form>


@endsection
