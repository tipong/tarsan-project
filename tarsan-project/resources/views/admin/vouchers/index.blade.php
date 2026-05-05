@extends('admin.layouts.app')

@section('title', 'Vouchers')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Vouchers</h1>

    <a href="{{ route('admin.vouchers.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Voucher
    </a>
</div>

{{-- FILTER --}}
<form method="GET" class="mb-4 flex items-center gap-3">
    <select name="status" class="border rounded px-4 py-2 w-40">
        <option value="">All</option>
        <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
        <option value="scheduled" {{ request('status')=='scheduled'?'selected':'' }}>Scheduled</option>
        <option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option>
        <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
    </select>


    <button
        type="submit"
        class="bg-blue-600 text-white px-6 py-2 rounded min-w-[120px] hover:bg-blue-700">
        Filter
    </button>

</form>

{{-- TABLE --}}
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">Code</th>
            <th>Amount</th>
            <th>Valid Time</th>
            <th>Status</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse($vouchers as $voucher)
            <tr class="border-t">
                <td class="p-3 font-semibold">{{ $voucher->code }}</td>

                <td>Rp {{ number_format($voucher->amount) }}</td>

                <td>
                    {{ $voucher->starts_at->format('d M Y H:i') }}
                    <br>
                    <span class="text-gray-500 text-xs">
                        s/d {{ $voucher->ends_at->format('d M Y H:i') }}
                    </span>
                </td>

                <td>
                    @if($voucher->status === 'active')
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                            Active
                        </span>
                    @elseif($voucher->status === 'scheduled')
                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-700">
                            Scheduled
                        </span>
                    @elseif($voucher->status === 'expired')
                        <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-600">
                            Expired
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                            Inactive
                        </span>
                    @endif
                </td>


                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                       class="text-blue-600 hover:underline">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.vouchers.destroy', $voucher) }}"
                          onsubmit="return confirm('Delete voucher ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-4 text-center text-gray-500">
                    No vouchers found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
