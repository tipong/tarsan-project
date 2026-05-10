@extends('admin.layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="grid md:grid-cols-4 gap-6 mb-8">
    {{-- Total Revenue --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500">Total Pendapatan</p>
        <h2 class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="text-sm text-slate-500">Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    {{-- Total Orders --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500">Total Transaksi</p>
        <h2 class="text-3xl font-bold">{{ $totalOrders }}</h2>
        <p class="text-sm text-slate-500">Pemesanan selesai</p>
    </div>

    {{-- Average Order --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500">Rata-rata Pemesanan</p>
        <h2 class="text-3xl font-bold">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h2>
        <p class="text-sm text-slate-500">Per transaksi</p>
    </div>

    {{-- Cash Payments --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500">Pembayaran Tunai</p>
        <h2 class="text-3xl font-bold">Rp {{ number_format($cashPayments, 0, ',', '.') }}</h2>
        <p class="text-sm text-slate-500">Metode pembayaran</p>
    </div>
</div>

{{-- Filter Section --}}
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h3 class="text-lg font-bold mb-4">Filter Laporan</h3>
    <form method="GET" action="{{ route('admin.reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Start Date --}}
        <div>
            <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none">
        </div>

        {{-- End Date --}}
        <div>
            <label class="block text-sm font-medium text-slate-800 font-semibold mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none">
        </div>

        {{-- Buttons --}}
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800">
                🔍 Filter
            </button>
            <a href="{{ route('admin.reports.financial') }}" class="px-4 py-2 bg-gray-300 text-slate-700 rounded-xl hover:bg-gray-400">
                Reset
            </a>
        </div>
    </form>

    {{-- Export Button (outside form) --}}
    <div class="mt-4">
        <a href="{{ route('admin.reports.financial.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
            📥 Export CSV
        </a>
    </div>
</div>

{{-- Payment Methods Breakdown --}}
<div class="grid md:grid-cols-3 gap-6 mb-8">
    {{-- Bank Transfer --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500 mb-2">Transfer Bank</p>
        <h3 class="text-2xl font-bold text-indigo-600">Rp {{ number_format($bankTransfers, 0, ',', '.') }}</h3>
        @if($totalRevenue > 0)
            <p class="text-sm text-slate-500">{{ round(($bankTransfers / $totalRevenue) * 100) }}% dari total</p>
        @endif
    </div>

    {{-- Card Payments --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500 mb-2">Pembayaran Kartu</p>
        <h3 class="text-2xl font-bold text-purple-600">Rp {{ number_format($cardPayments, 0, ',', '.') }}</h3>
        @if($totalRevenue > 0)
            <p class="text-sm text-slate-500">{{ round(($cardPayments / $totalRevenue) * 100) }}% dari total</p>
        @endif
    </div>

    {{-- Cash --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <p class="text-slate-500 mb-2">Tunai</p>
        <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($cashPayments, 0, ',', '.') }}</h3>
        @if($totalRevenue > 0)
            <p class="text-sm text-slate-500">{{ round(($cashPayments / $totalRevenue) * 100) }}% dari total</p>
        @endif
    </div>
</div>

{{-- Room Revenue Table --}}
<div class="bg-white p-6 rounded-xl shadow mb-8">
    <h3 class="text-lg font-bold mb-4">Pendapatan Per Kamar</h3>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Kamar</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Jumlah Transaksi</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-slate-700">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roomRevenue as $room)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">{{ $room['room'] }}</td>
                        <td class="px-6 py-3">{{ $room['count'] }} transaksi</td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($room['revenue'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-3 text-center text-slate-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Transactions Table --}}
<div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-lg font-bold mb-4">Daftar Transaksi</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-slate-700">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-700">Kode Pesanan</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-700">Tamu</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-700">Kamar</th>
                    <th class="px-6 py-3 text-left font-semibold text-slate-700">Metode</th>
                    <th class="px-6 py-3 text-right font-semibold text-slate-700">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3">{{ $order->created_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-6 py-3 font-mono text-indigo-600">{{ $order->order_code ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $order->guest_display_name ?? '-' }}</td>
                        <td class="px-6 py-3">
                            @if($order->items && $order->items->count() > 0)
                                @foreach($order->items as $item)
                                    @if($item->room)
                                        <div class="text-xs">{{ $item->room->room_name }}</div>
                                    @endif
                                @endforeach
                            @elseif($order->is_walkin)
                                <span class="text-xs text-slate-500">Walk-in</span>
                            @else
                                <span class="text-xs text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            @if($order->payment_method === 'cash')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-xl text-xs">💵 Tunai</span>
                            @elseif($order->payment_method === 'bank_transfer')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-xl text-xs">🏦 Transfer</span>
                            @elseif($order->payment_method === 'card')
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-xl text-xs">💳 Kartu</span>
                            @else
                                <span class="px-2 py-1 bg-slate-50 text-slate-600 rounded-xl text-xs">{{ $order->payment_method ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-3 text-center text-slate-500">Tidak ada transaksi dalam periode ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
