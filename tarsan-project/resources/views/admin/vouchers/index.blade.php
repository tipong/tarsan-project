@extends('admin.layouts.app')

@section('title', 'Vouchers')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Vouchers</h1>

    <a href="{{ route('admin.vouchers.create') }}"
       class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-md text-sm font-medium">
        + Add Voucher
    </a>
</div>

{{-- FILTER --}}
<form method="GET" class="mb-4 flex flex-wrap gap-2 items-center">
    <select name="status"
            class="border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-slate-900 focus:border-slate-900 text-sm outline-none transition-all bg-white text-slate-800 focus:ring-2 focus:ring-indigo-600 focus:border-slate-900">
        <option value="">All</option>
        <option value="active" {{ request('status')=='active'?'selected' : '' }}>Active</option>
        <option value="scheduled" {{ request('status')=='scheduled'?'selected' : '' }}>Scheduled</option>
        <option value="expired" {{ request('status')=='expired'?'selected' : '' }}>Expired</option>
        <option value="inactive" {{ request('status')=='inactive'?'selected' : '' }}>Inactive</option>
    </select>

    <button type="submit"
            class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 transition-colors shadow-md text-sm font-medium">
        Filter
    </button>

    <a href="{{ route('admin.vouchers.index') }}"
       class="px-5 py-2.5 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors text-sm font-medium text-slate-700-xl hover:bg-slate-50">
        Reset
    </a>
</form>

@if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- TABLE --}}
<div class="bg-white rounded-xl shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Valid Time</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($vouchers as $voucher)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="p-3 font-semibold">{{ $voucher->code }}</td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">Rp {{ number_format($voucher->amount) }}</td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        <div>
                            <div>{{ $voucher->starts_at->format('d M Y H:i') }}</div>
                            <div class="text-xs text-slate-500">
                                s/d {{ $voucher->ends_at->format('d M Y H:i') }}
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        @if($voucher->status === 'active')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        @elseif($voucher->status === 'scheduled')
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                Scheduled
                            </span>
                        @elseif($voucher->status === 'expired')
                            <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-600">
                                Expired
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 border-b border-slate-50 text-sm">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                               class="text-indigo-600 hover:underline text-xs font-medium">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.vouchers.destroy', $voucher) }}"
                                  onsubmit="return confirm('Delete voucher ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-slate-500">
                        No vouchers found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($vouchers->hasPages())
    <div class="mt-4">
        {{ $vouchers->links() }}
    </div>
@endif
@endsection
