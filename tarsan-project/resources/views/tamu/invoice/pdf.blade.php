<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->invoice_number ?? $order->order_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #2563eb;
            color: #fff;
            padding: 20px;
            margin: -20px -20px 20px -20px;
        }
        .header .left {
            float: left;
        }
        .header .right {
            float: right;
            text-align: right;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 11px;
            color: #bfdbfe;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .grid-2 {
            width: 100%;
        }
        .grid-2 .col {
            width: 50%;
            float: left;
            padding-right: 20px;
        }
        .grid-2 .col:last-child {
            padding-right: 0;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-label {
            color: #6b7280;
            font-size: 10px;
        }
        .info-value {
            font-weight: 600;
            color: #111;
        }
        .stay-details {
            background: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stay-grid-3 {
            width: 100%;
        }
        .stay-grid-3 .col {
            width: 33.33%;
            float: left;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th {
            background: #f3f4f6;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            color: #4b5563;
            border-bottom: 2px solid #e5e7eb;
        }
        .table th.text-center {
            text-align: center;
        }
        .table th.text-right {
            text-align: right;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .table td.text-center {
            text-align: center;
        }
        .table td.text-right {
            text-align: right;
        }
        .summary {
            width: 300px;
            margin-left: auto;
            border-top: 2px solid #e5e7eb;
            padding-top: 15px;
        }
        .summary-row {
            display: block;
            margin-bottom: 5px;
        }
        .summary-row .label {
            float: left;
            color: #6b7280;
        }
        .summary-row .value {
            float: right;
            font-weight: 600;
        }
        .summary-total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #e5e7eb;
        }
        .summary-total .label {
            font-size: 14px;
            font-weight: bold;
            color: #111;
        }
        .summary-total .value {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 10px;
        }
        .payment-method {
            background: #f9fafb;
            padding: 10px 15px;
            border-radius: 3px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header clearfix">
            <div class="left">
                <h1>INVOICE</h1>
                <p>{{ $order->invoice_number ?? $order->order_code }}</p>
            </div>
            <div class="right">
                <p style="font-size: 14px; font-weight: bold; color: #fff;">Tarsan Homestay</p>
                <p>Labuan Bajo, Nusa Tenggara Timur</p>
                <p>tarsanhomestay@gmail.com</p>
            </div>
        </div>

        {{-- Booking Info & Account Info --}}
        <div class="section">
            <div class="grid-2 clearfix">
                <div class="col">
                    <div class="section-title">Detail Pemesanan</div>
                    <div class="info-row">
                        <div class="info-label">Tanggal Pemesanan</div>
                        <div class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Kode Pesanan</div>
                        <div class="info-value">{{ $order->order_code ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Status Pembayaran</div>
                        <div class="info-value" style="color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#ca8a04' }};">
                            {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="section-title">Informasi Akun</div>
                    <div class="info-row">
                        <div class="info-label">Username Akun</div>
                        <div class="info-value">{{ $order->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email Akun</div>
                        <div class="info-value">{{ $order->user->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stay Details --}}
        <div class="stay-details clearfix">
            <div class="section-title">Detail Menginap</div>
            <div class="stay-grid-3 clearfix">
                <div class="col">
                    <div class="info-label">Check-in</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->check_in?->format('d M Y') ?? 'N/A' }}</div>
                    <div class="info-label">dari pukul 14:00 WITA</div>
                </div>
                <div class="col">
                    <div class="info-label">Check-out</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->check_out?->format('d M Y') ?? 'N/A' }}</div>
                    <div class="info-label">sebelum pukul 12:00 WITA</div>
                </div>
                <div class="col">
                    <div class="info-label">Durasi</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->nights ?? 1 }} Malam</div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        @if($order->items && $order->items->count() > 0)
        <div class="section">
            <div class="section-title">Rincian Pesanan</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kamar</th>
                        <th class="text-center">Harga/Malam</th>
                        <th class="text-center">Malam</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->room->room_name ?? 'N/A' }}</strong>
                            @if($item->room && $item->room->capacity)
                            <br><span style="font-size: 10px; color: #6b7280;">Kapasitas: {{ $item->room->capacity }} orang</span>
                            @endif
                        </td>
                        <td class="text-center">Rp {{ number_format($item->price_per_night ?? 0, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->nights ?? $order->nights ?? 1 }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Informasi Tamu (Moved to Bottom) --}}
        <div class="stay-details clearfix">
            <div class="section-title">Informasi Tamu</div>
            <div class="stay-grid-3 clearfix">
                <div class="col">
                    <div class="info-label">Nama Tamu</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->guest_name ?? $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->guest_phone ?? $order->user->phone ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="info-label">Email Guest</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->user->email ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="summary clearfix">
            <div class="summary-row">
                <span class="label">Subtotal</span>
                <span class="value">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
            </div>
            @if($order->discount_amount ?? 0 > 0)
            <div class="summary-row" style="color: #16a34a;">
                <span class="label">Diskon</span>
                <span class="value">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="summary-total summary-row">
                <span class="label">Total</span>
                <span class="value">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Payment Method --}}
        @if($order->payment_method)
        <div class="payment-method">
            <div class="section-title" style="margin-bottom: 5px;">Metode Pembayaran</div>
            <div class="info-value">{{ ucfirst($order->payment_method) }}</div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan atau stempel.</p>
            <p>Terima kasih telah memilih Tarsan Homestay.</p>
        </div>
    </div>
</body>
</html>
