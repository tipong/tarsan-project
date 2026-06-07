<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - Tarsan Homestay</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #334155;
            line-height: 1.4;
            padding: 30px;
        }
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header .title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
        }
        .header .subtitle {
            font-size: 12px;
            color: #4f46e5;
            font-weight: bold;
            margin-top: 3px;
        }
        .header .meta {
            font-size: 10px;
            color: #64748b;
            margin-top: 5px;
        }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
        }
        .card-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 6px;
            vertical-align: top;
        }
        .card-indigo {
            background: #4f46e5;
            color: #ffffff;
            border: 1px solid #4f46e5;
            padding: 12px;
            border-radius: 6px;
            vertical-align: top;
        }
        .card-title {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .card-indigo .card-title {
            color: #c7d2fe;
        }
        .card-value {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }
        .card-indigo .card-value {
            color: #ffffff;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background: #f1f5f9;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            color: #475569;
            border-bottom: 1.5px solid #cbd5e1;
        }
        .table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-cash {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-other {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <div class="title">TARSAN HOMESTAY</div>
        <div class="subtitle">Laporan Keuangan (Financial Report)</div>
        <div class="meta">
            Periode Laporan: <strong>{{ $startDate->format('d M Y') }}</strong> s/d <strong>{{ $endDate->format('d M Y') }}</strong>
            <br>
            Tanggal Unduh: {{ now()->format('d M Y H:i:s') }}
        </div>
    </div>

    {{-- Stats Cards Table --}}
    <table class="card-table" style="margin-bottom: 10px;">
        <tr>
            <td class="card" style="width: 24%; padding-right: 15px;">
                <div class="card-title">Total Revenue</div>
                <div class="card-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </td>
            <td style="width: 1.33%"></td>
            <td class="card" style="width: 24%;">
                <div class="card-title">Transactions</div>
                <div class="card-value">{{ $totalOrders }}</div>
            </td>
            <td style="width: 1.33%"></td>
            <td class="card" style="width: 24%;">
                <div class="card-title">Avg. Transaction</div>
                <div class="card-value" style="font-size: 12px; margin-top: 2px;">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</div>
            </td>
            <td style="width: 1.33%"></td>
            <td class="card-indigo" style="width: 24%;">
                <div class="card-title">Report Status</div>
                <div class="card-value" style="font-style: italic;">Verified</div>
            </td>
        </tr>
    </table>

    {{-- Payment Methods Stats Table --}}
    <div class="section-title">Ringkasan Metode Pembayaran</div>
    <table class="card-table">
        <tr>
            <td class="card" style="width: 32%; background: #f0fdf4; border-color: #bbf7d0;">
                <div class="card-title" style="color: #166534;">Cash Payments</div>
                <div class="card-value" style="color: #14532d;">Rp {{ number_format($cashPayments, 0, ',', '.') }}</div>
            </td>
            <td style="width: 2%"></td>
            <td class="card" style="width: 32%; background: #eff6ff; border-color: #bfdbfe;">
                <div class="card-title" style="color: #1e40af;">Bank Transfers</div>
                <div class="card-value" style="color: #1e3a8a;">Rp {{ number_format($bankTransfers, 0, ',', '.') }}</div>
            </td>
            <td style="width: 2%"></td>
            <td class="card" style="width: 32%; background: #faf5ff; border-color: #e9d5ff;">
                <div class="card-title" style="color: #6b21a8;">Card Payments</div>
                <div class="card-value" style="color: #581c87;">Rp {{ number_format($cardPayments, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    {{-- Room Revenue Section --}}
    <div class="section-title">Pendapatan Per Kamar (Detail)</div>
    @forelse($roomRevenue as $room)
        <div style="margin-bottom: 25px;">
            <div style="background: #f8fafc; border-left: 3px solid #4f46e5; padding: 6px 10px; font-weight: bold; font-size: 11px; color: #1e293b; margin-bottom: 8px;">
                {{ $room['room'] }} &mdash; Total Pendapatan: <span style="color: #4f46e5;">Rp {{ number_format($room['revenue'], 0, ',', '.') }}</span> ({{ $room['count'] }} Transaksi)
            </div>
            <table class="table" style="font-size: 9.5px; margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="width: 120px;">Date Order</th>
                        <th style="width: 90px;">Order Code</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th class="text-right" style="width: 110px;">Total Price</th>
                        <th class="text-center" style="width: 100px;">Payment Method</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($room['orders'] as $ord)
                    <tr>
                        <td style="color: #64748b;">{{ $ord['date']->format('d/m/Y H:i') }}</td>
                        <td style="font-family: monospace; font-weight: bold; color: #4f46e5;">{{ $ord['order_code'] }}</td>
                        <td style="font-weight: bold; color: #334155;">{{ $ord['guest'] }}</td>
                        <td style="color: #475569;">{{ $ord['room'] }}</td>
                        <td class="text-right" style="font-weight: bold; color: #0f172a;">Rp {{ number_format($ord['total_price'], 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $ord['payment_method'] === 'cash' ? 'badge-cash' : 'badge-other' }}">
                                {{ strtoupper($ord['payment_method']) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <div class="text-center" style="color: #94a3b8; font-style: italic; padding: 15px 0;">Tidak ada data pendapatan kamar.</div>
    @endforelse

    {{-- Page break for cleaner display if transactions table is long --}}
    <div style="page-break-before: always;"></div>

    <div class="header" style="border-bottom: 1px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 15px;">
        <div class="title" style="font-size: 14px;">TARSAN HOMESTAY</div>
        <div class="subtitle" style="font-size: 10px; margin-top: 1px;">Daftar Transaksi Detail ({{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }})</div>
    </div>

    {{-- Transactions Table --}}
    <table class="table" style="font-size: 9.5px;">
        <thead>
            <tr>
                <th style="width: 110px;">Waktu Transaksi</th>
                <th style="width: 90px;">Kode Order</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th class="text-center" style="width: 90px;">Metode</th>
                <th class="text-right" style="width: 100px;">Jumlah Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                @php
                    $roomNames = $order->items->map(function($item) {
                        return $item->room?->room_name;
                    })->filter()->implode(', ');
                @endphp
                <tr>
                    <td style="color: #64748b;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td style="font-family: monospace; font-weight: bold; color: #4f46e5;">{{ $order->order_code }}</td>
                    <td style="font-weight: bold; color: #334155;">{{ $order->user?->name ?? $order->guest_name }}</td>
                    <td style="color: #475569;">{{ $roomNames ?: '-' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $order->payment_method === 'cash' ? 'badge-cash' : 'badge-other' }}">
                            {{ strtoupper($order->payment_method ?? '-') }}
                        </span>
                    </td>
                    <td class="text-right" style="font-weight: bold; color: #0f172a;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #94a3b8; font-style: italic;">Tidak ada transaksi pembayaran dalam periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini dibuat otomatis oleh Sistem Tarsan Homestay dan sah tanpa tanda tangan fisik.
    </div>
</body>
</html>
