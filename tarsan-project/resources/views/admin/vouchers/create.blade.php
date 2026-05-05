@extends('admin.layouts.app')

@section('title', 'Add Voucher')

@section('content')

<form method="POST" action="{{ route('admin.vouchers.store') }}"
      class="bg-white p-6 rounded shadow max-w-xl">
@csrf

<div class="space-y-4">

    <input
        type="text"
        name="code"
        placeholder="Voucher Code"
        class="w-full border rounded px-3 py-2"
        required>

    <input
        type="number"
        name="amount"
        placeholder="Nominal (Rp)"
        class="w-full border rounded px-3 py-2"
        required>

    {{-- START DATETIME --}}
    <div>
        <label class="text-sm text-gray-600">Start Time</label>
        <input
            type="datetime-local"
            name="starts_at"
            class="w-full border rounded px-3 py-2"
            required>
    </div>

    {{-- END DATETIME --}}
    <div>
        <label class="text-sm text-gray-600">End Time</label>
        <input
            type="datetime-local"
            name="ends_at"
            class="w-full border rounded px-3 py-2"
            required>
    </div>

    <button
        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Save Voucher
    </button>

</div>
</form>


@endsection
