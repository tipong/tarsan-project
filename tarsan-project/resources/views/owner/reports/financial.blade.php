@extends('admin.layouts.app')

@section('title', 'Financial Report')

@section('content')
{{-- Quick Date Filter --}}
<div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <h3 class="text-sm font-bold text-slate-700">Rentang Waktu</h3>
    </div>

    <form method="GET" action="{{ route('owner.reports.financial') }}" id="filterForm">
        {{-- Hidden date inputs that get populated by JS --}}
        <input type="hidden" name="start_date" id="start_date_input" value="{{ $startDate->format('Y-m-d') }}">
        <input type="hidden" name="end_date"   id="end_date_input"   value="{{ $endDate->format('Y-m-d') }}">
        <input type="hidden" name="preset"     id="preset_input"     value="{{ request('preset', '') }}">

        {{-- Quick preset buttons --}}
        @php
            $preset = $preset ?? request('preset', '');
            $presets = [
                'today'      => 'Today',
                'yesterday'  => 'Yesterday',
                'last_week'  => 'Last Week',
                'last_month' => 'Last Month',
                'last_year'  => 'Last Year',
                'custom'     => 'Custom Range',
            ];
        @endphp
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($presets as $key => $label)
                <button
                    type="button"
                    onclick="applyPreset('{{ $key }}')"
                    id="btn-{{ $key }}"
                    class="preset-btn px-4 py-2 rounded-xl text-xs font-semibold border transition-all duration-200
                           {{ $preset === $key
                               ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm'
                               : 'bg-slate-50 text-slate-600 border-slate-200 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Custom range date inputs (hidden unless custom preset selected) --}}
        <div id="customRangePanel" class="{{ $preset === 'custom' ? 'flex' : 'hidden' }} flex-col sm:flex-row gap-3 items-end border-t border-slate-100 pt-4 mt-2">
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Start Date</label>
                <input type="date" id="custom_start" value="{{ $startDate->format('Y-m-d') }}"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none text-sm bg-slate-50">
            </div>
            <div class="flex-1 w-full">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">End Date</label>
                <input type="date" id="custom_end" value="{{ $endDate->format('Y-m-d') }}"
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-600 outline-none text-sm bg-slate-50">
            </div>
            <button type="button" onclick="submitCustomRange()"
                    class="w-full sm:w-auto shrink-0 px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-semibold text-sm">
                Terapkan
            </button>
        </div>

        {{-- Active period badge --}}
        <div class="mt-4 flex flex-wrap items-center gap-2">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Periode aktif:</span>
            <span class="inline-flex items-center gap-1 px-3 py-1 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $startDate->format('d M Y') }} – {{ $endDate->format('d M Y') }}
            </span>
            @if(request()->hasAny(['start_date','end_date','preset']))
                <a href="{{ route('owner.reports.financial') }}" class="text-[10px] text-rose-500 hover:text-rose-700 font-bold uppercase tracking-wider transition">Reset</a>
            @endif
        </div>
    </form>
</div>


{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    {{-- Total Revenue --}}
    <div class="col-span-2 sm:col-span-1 bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-xs md:text-sm font-medium mb-1">Total Revenue</p>
        <h2 class="text-xl md:text-3xl font-bold text-slate-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <p class="text-xs text-slate-400 mt-2">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</p>
    </div>

    {{-- Total Orders --}}
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-xs md:text-sm font-medium mb-1">Transactions</p>
        <h2 class="text-2xl md:text-3xl font-bold text-slate-900">{{ $totalOrders }}</h2>
        <p class="text-xs text-slate-400 mt-2">Successful bookings</p>
    </div>

    {{-- Average Order --}}
    <div class="bg-white p-4 md:p-6 rounded-2xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-xs md:text-sm font-medium mb-1">Avg. Transaction</p>
        <h2 class="text-lg md:text-3xl font-bold text-slate-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h2>
        <p class="text-xs text-slate-400 mt-2">Per order</p>
    </div>

    {{-- Growth/Info --}}
    <div class="bg-indigo-600 p-4 md:p-6 rounded-2xl shadow-md text-white">
        <p class="text-indigo-100 text-xs md:text-sm font-medium mb-1">Report Status</p>
        <h2 class="text-xl md:text-2xl font-bold italic">Verified</h2>
        <p class="text-xs text-indigo-200 mt-2">Real-time data</p>
    </div>
</div>

{{-- CHARTS SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 md:gap-8 mb-8">
    {{-- Revenue Chart --}}
    <div class="lg:col-span-2 bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-4 md:mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
            </svg>
            Daily Revenue Trend
        </h3>
        <div class="h-[220px] md:h-[300px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Payment Methods Pie Chart --}}
    <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="text-base md:text-lg font-bold text-slate-800 mb-4 md:mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
            </svg>
            Payment Methods
        </h3>
        <div class="h-[220px] md:h-[300px] flex items-center justify-center">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
</div>

<div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5 md:mb-6">
        <h3 class="text-base md:text-lg font-bold text-slate-800">Filter & Export</h3>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="{{ route('owner.reports.financial.export', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition shadow-sm font-medium text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
            <a href="{{ route('owner.reports.financial.pdf', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition shadow-sm font-medium text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Download PDF
            </a>
        </div>
    </div>
</div>

{{-- Room Revenue --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
    <div class="p-5 md:p-6 border-b border-slate-50">
        <h3 class="text-base md:text-lg font-bold text-slate-800">Revenue Per Room</h3>
    </div>
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50/70">
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Room</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Transactions</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($roomRevenue as $room)
                    <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5">
                        <td class="px-6 py-4 font-bold text-slate-800 group-hover:text-indigo-600 transition-colors duration-200">{{ $room['room'] }}</td>
                        <td class="px-6 py-4 text-center text-slate-600 font-semibold">{{ $room['count'] }}</td>
                        <td class="px-6 py-4 text-right font-black text-indigo-600">Rp {{ number_format($room['revenue'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- MOBILE VIEW --}}
    <div class="md:hidden divide-y divide-slate-100">
        @foreach($roomRevenue as $room)
            <div class="p-4 flex items-center justify-between hover:bg-slate-50/50 transition duration-150">
                <div>
                    <p class="font-bold text-slate-800 text-sm">{{ $room['room'] }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">{{ $room['count'] }} Transactions</p>
                </div>
                <p class="font-black text-indigo-600 text-sm">Rp {{ number_format($room['revenue'], 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>
</div>

{{-- Latest Transactions --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-5 md:p-6 border-b border-slate-50">
        <h3 class="text-base md:text-lg font-bold text-slate-800">Latest Transactions</h3>
    </div>
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50/70">
                <tr class="border-b border-slate-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Guest</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Method</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($orders->take(10) as $order)
                    <tr class="group hover:bg-indigo-50/10 transition-all duration-200 hover:translate-x-0.5 text-xs md:text-sm">
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 font-mono font-bold text-indigo-600 whitespace-nowrap">{{ $order->order_code }}</td>
                        <td class="px-6 py-4 text-slate-800 font-semibold hidden sm:table-cell">{{ $order->user?->name ?? $order->guest_name }}</td>
                        <td class="px-6 py-4 text-center hidden md:table-cell">
                            @if($order->payment_method === 'cash')
                                <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded font-bold text-[9px] uppercase border border-emerald-100">CASH</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 text-blue-600 rounded font-bold text-[9px] uppercase border border-blue-100">{{ $order->payment_method }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right font-bold whitespace-nowrap text-slate-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="p-1.5 inline-flex items-center gap-1.5 bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 text-indigo-600 rounded-xl text-[10px] font-bold transition duration-200 border border-slate-200/60 hover:shadow-sm">
                                Detail
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- MOBILE VIEW --}}
    <div class="md:hidden divide-y divide-slate-100">
        @foreach($orders->take(10) as $order)
            <div class="p-4 space-y-2 hover:bg-slate-50/50 transition duration-150">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100">{{ $order->order_code }}</span>
                    <span class="text-[10px] text-slate-400 font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $order->user?->name ?? $order->guest_name }}</p>
                        @if($order->payment_method === 'cash')
                            <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded font-bold text-[9px] uppercase border border-emerald-100 mt-0.5">CASH</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 text-blue-600 rounded font-bold text-[9px] uppercase border border-blue-100 mt-0.5">{{ $order->payment_method }}</span>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="font-black text-slate-900 text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <a href="{{ route('admin.orders.show', $order) }}" class="mt-2 inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 hover:text-indigo-700 transition">
                            Detail
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
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
            labels: labels,
            datasets: [{
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
                        },
                        maxTicksLimit: 5
                    },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: {
                    grid: { display: false },
                    ticks: { maxTicksLimit: 7 }
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
                    labels: { usePointStyle: true, padding: 16, font: { size: 11 } }
                }
            },
            cutout: '70%'
        }
    });

    // ---- Quick Filter JS ----
    (function () {
        const today = new Date();

        function fmt(d) {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        window.applyPreset = function(preset) {
            let start, end;

            if (preset === 'today') {
                start = end = new Date(today);
            } else if (preset === 'yesterday') {
                const y = new Date(today);
                y.setDate(today.getDate() - 1);
                start = end = y;
            } else if (preset === 'last_week') {
                start = new Date(today);
                start.setDate(today.getDate() - 7);
                end = new Date(today);
            } else if (preset === 'last_month') {
                start = new Date(today);
                start.setMonth(today.getMonth() - 1);
                end = new Date(today);
            } else if (preset === 'last_year') {
                start = new Date(today);
                start.setFullYear(today.getFullYear() - 1);
                end = new Date(today);
            } else if (preset === 'custom') {
                document.getElementById('customRangePanel').classList.remove('hidden');
                document.getElementById('customRangePanel').classList.add('flex');
                document.getElementById('preset_input').value = 'custom';
                return;
            }

            document.getElementById('start_date_input').value = fmt(start);
            document.getElementById('end_date_input').value   = fmt(end);
            document.getElementById('preset_input').value     = preset;
            document.getElementById('customRangePanel').classList.add('hidden');
            document.getElementById('customRangePanel').classList.remove('flex');
            document.getElementById('filterForm').submit();
        };

        window.submitCustomRange = function() {
            const s = document.getElementById('custom_start').value;
            const e = document.getElementById('custom_end').value;
            if (!s || !e) { alert('Pilih tanggal mulai dan akhir.'); return; }
            document.getElementById('start_date_input').value = s;
            document.getElementById('end_date_input').value   = e;
            document.getElementById('preset_input').value     = 'custom';
            document.getElementById('filterForm').submit();
        };
    })();
</script>
@endsection
