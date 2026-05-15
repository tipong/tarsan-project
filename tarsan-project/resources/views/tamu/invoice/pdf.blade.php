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
                        <div class="info-label">Account Username</div>
                        <div class="info-value">{{ $order->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Payment Status</div>
                        <div class="info-value" style="color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#ca8a04' }};">
                            {{ $order->payment_status === 'paid' ? 'Paid' : 'Not Paid' }}
                        </div>
                    </div>
                </div>
                <div class="col" style="text-align: right;">
                    <div class="section-title">ID Transaksi</div>
                    <div class="info-value" style="font-size: 16px; color: #2563eb;">{{ $order->order_code ?? 'N/A' }}</div>
                    <p style="font-size: 9px; color: #6b7280;">Use this code as reference</p>
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
                    <div class="info-label">from 14:00 WITA</div>
                </div>
                <div class="col">
                    <div class="info-label">Check-out</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->check_out?->format('d M Y') ?? 'N/A' }}</div>
                    <div class="info-label">before 12:00 WITA</div>
                </div>
                <div class="col">
                    <div class="info-label">Durasi</div>
                    <div class="info-value" style="font-size: 14px;">{{ $order->nights ?? 1 }} Night</div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        @if($order->items && $order->items->count() > 0)
        <div class="section">
            <div class="section-title">Order Details</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th class="text-center">Price/Night</th>
                        <th class="text-center">Nights</th>
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

        {{-- Guest Information (Moved to Bottom) --}}
        <div class="stay-details clearfix" style="background: #eef2ff; border: 1px solid #e0e7ff;">
            <div class="section-title" style="color: #4338ca; border-bottom-color: #c7d2fe;">Guest Information (Stay Details)</div>
            <div class="stay-grid-3 clearfix">
                <div class="col">
                    <div class="info-label" style="color: #6366f1;">Guest Name</div>
                    <div class="info-value" style="font-size: 14px; color: #312e81;">{{ $order->guest_name ?? $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="info-label" style="color: #6366f1;">Phone Number</div>
                    <div class="info-value" style="font-size: 14px; color: #312e81;">{{ $order->guest_phone ?? $order->user->phone ?? 'N/A' }}</div>
                </div>
                <div class="col">
                    <div class="info-label" style="color: #6366f1;">Contact Email</div>
                    <div class="info-value" style="font-size: 14px; color: #312e81;">{{ $order->user->email ?? '-' }}</div>
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
                <span class="label">Discount</span>
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
            <div class="section-title" style="margin-bottom: 5px;">Payment Method</div>
            <div class="info-value">{{ ucfirst($order->payment_method) }}</div>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>This invoice is generated automatically and is valid without signature or stamp.</p>
            <p>Thank you for choosing Tarsan Homestay.</p>
        </div>
    </div>
</body>
</html>
