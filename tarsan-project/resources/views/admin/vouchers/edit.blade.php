@extends('admin.layouts.app')

@section('title', 'Edit Voucher')

@section('content')
<h1 class="text-xl font-semibold mb-4">Edit Voucher</h1>

<form method="POST"
      action="{{ route('admin.vouchers.update', $voucher) }}"
      class="bg-white p-6 rounded shadow max-w-xl">
@csrf
@method('PUT')

<div class="space-y-4">

    <input
        name="code"
        value="{{ old('code', $voucher->code) }}"
        class="w-full border rounded p-2"
        required>

    <input
        type="number"
        name="amount"
        value="{{ old('amount', $voucher->amount) }}"
        class="w-full border rounded p-2"
        required>

    <input
        type="datetime-local"
        name="starts_at"
        value="{{ old('starts_at', $voucher->starts_at->format('Y-m-d\TH:i')) }}"
        class="w-full border rounded p-2"
        required>

    <input
        type="datetime-local"
        name="ends_at"
        value="{{ old('ends_at', $voucher->ends_at->format('Y-m-d\TH:i')) }}"
        class="w-full border rounded p-2"
        required>

    {{-- PAKSA kirim 0 jika checkbox tidak dicentang --}}
    <input type="hidden" name="is_active" value="0">

    <label class="flex items-center gap-2">
        <input type="checkbox"
            name="is_active"
            value="1"
            {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
        Active
    </label>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

</div>
</form>
@endsection