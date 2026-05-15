@extends('admin.layouts.app')

@section('title', 'Financial Report')

@section('content')
<div class="grid md:grid-cols-4 gap-6 mb-8">
    {{-- Total Revenue --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-sm font-medium mb-1">Total Revenue</p>
        <h2 class="text-3xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="text-xs text-slate-400 mt-2">Period: {{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    {{-- Total Orders --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-sm font-medium mb-1">Total Transactions</p>
        <h2 class="text-3xl font-bold text-slate-900">{{ $totalOrders }}</h2>
        <p class="text-xs text-slate-400 mt-2">Successful bookings</p>
    </div>

    {{-- Average Order --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-sm font-medium mb-1">Average Transaction</p>
        <h2 class="text-3xl font-bold text-slate-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h2>
        <p class="text-xs text-slate-400 mt-2">Per order</p>
    </div>

    {{-- Growth/Info --}}
    <div class="bg-indigo-600 p-6 rounded-2xl shadow-md text-white">
        <p class="text-indigo-100 text-sm font-medium mb-1">Report Status</p>
        <h2 class="text-2xl font-bold italic">Verified</h2>
        <p class="text-xs text-indigo-200 mt-2">Real-time system data</p>
    </div>
</div>

{{-- CHARTS SECTION --}}
<div class="grid md:grid-cols-3 gap-8 mb-8">
    {{-- Revenue Chart --}}
    <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            Daily Revenue Trend
        </h3>
        <div class="h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{--            Metode PembayaranPie Chart --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
            </svg>
            Payment Methods
        </h3>
        <div class="h-[300px] flex items-center justify-center">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
</div>

{{-- Filter Section --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h3 class="text-lg font-bold text-slate-800">Filter & Export</h3>
        <a href="{{ route('owner.reports.financial.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
           class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-sm font-medium text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export CSV
        </a>
    </div>

    <form method="GET" action="{{ route('owner.reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                   class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none text-sm">
        </div>

        <div class="md:col-span-2 flex items-end gap-2">
            <button type="submit" class="flex-1 px-6 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition font-medium text-sm">
                Apply Filter
            </button>
            <a href="{{ route('owner.reports.financial') }}" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition font-medium text-sm">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Room Revenue --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-50">
        <h3 class="text-lg font-bold text-slate-800">Revenue Per Room</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider">Transactions</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider">Total Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($roomRevenue as $room)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $room['room'] }}</td>
                        <td class="px-6 py-4 text-center text-slate-600">{{ $room['count'] }}</td>
                        <td class="px-6 py-4 text-right font-black text-indigo-600">Rp {{ number_format($room['revenue'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Latest Transactions --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50">
        <h3 class="text-lg font-bold text-slate-800">Latest Transactions List</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50/50">
                <tr>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Guest</th>
                    <th class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-4 text-right font-bold text-slate-500 uppercase tracking-wider">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($orders->take(10) as $order)
                    <tr class="hover:bg-slate-50/50 transition text-xs md:text-sm">
                        <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-mono font-bold text-indigo-600">{{ $order->order_code }}</td>
                        <td class="px-6 py-4 text-slate-800 font-medium">{{ $order->user?->name ?? $order->guest_name }}</td>
                        <td class="px-6 py-4">
                            @if($order->payment_method === 'cash')
                                <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-bold text-[10px]">CASH</span>
                            @else
                                <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-lg font-bold text-[10px] uppercase">{{ $order->payment_method }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for Revenue Chart
    const dailyData = @json($dailyRevenue);
    const labels = Object.keys(dailyData).map(date => {
        const d = new Date(date);
        return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    });
    const values = Object.values(dailyData);

    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: labels,                            datasets: [{
                label: 'Revenue',
                data: values,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4f46e5',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Data for Payment Method Chart
    const ctxPayment = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctxPayment, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'Bank Transfer', 'Card'],
            datasets: [{
                data: [{{ $cashPayments }}, {{ $bankTransfers }}, {{ $cardPayments }}],
                backgroundColor: ['#10b981', '#4f46e5', '#a855f7'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 20 }
                }
            },
            cutout: '70%'
        }
    });
</script>
@endsection
