@extends('layouts.tamu-inner')
@section('title', 'Invoice - ' . ($order->invoice_number ?? $order->order_code))
@section('page-tag', 'Invoice')
@section('page-title', 'Invoice Document')
@section('page-sub', 'Booking Code: ' . ($order->order_code ?? 'N/A'))

@push('styles')
<style>
.inv-wrap{background:#fff;border:1px solid rgba(0,0,0,.07);padding:40px;max-width:800px;margin:0 auto 40px}
.inv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:40px;border-bottom:1px solid rgba(0,0,0,.06);padding-bottom:32px}
.inv-title{font-family:'Playfair Display',serif;font-size:36px;font-weight:400;color:#1a1a1a;line-height:1;margin-bottom:8px}
.inv-num{font-size:14px;color:#666;letter-spacing:.05em}
.inv-company{text-align:right}
.inv-company-name{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:4px}
.inv-company-info{font-size:12px;color:#888;line-height:1.6}
.inv-grid{display:grid;grid-template-columns:1fr 1fr;gap:40px;margin-bottom:40px}
.ig-title{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;margin-bottom:12px}
.ig-row{display:flex;justify-content:space-between;margin-bottom:8px;font-size:13px}
.ig-label{color:#666}
.ig-val{color:#1a1a1a;font-weight:500}
.ig-val-paid{color:#059669;font-weight:600}
.ig-val-unpaid{color:#d97706;font-weight:600}
.inv-box{background:#f8f5ef;padding:24px;margin-bottom:40px}
.inv-table{width:100%;border-collapse:collapse;margin-bottom:40px}
.inv-table th{text-align:left;font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;padding:12px 0;border-bottom:1px solid rgba(0,0,0,.1)}
.inv-table td{padding:16px 0;border-bottom:1px solid rgba(0,0,0,.06);font-size:14px;color:#1a1a1a}
.inv-table .t-right{text-align:right}
.inv-table .t-center{text-align:center}
.inv-summary{width:300px;margin-left:auto}
.is-row{display:flex;justify-content:space-between;margin-bottom:12px;font-size:14px;color:#666}
.is-val{color:#1a1a1a}
.is-total{display:flex;justify-content:space-between;padding-top:16px;border-top:1px solid rgba(0,0,0,.1);margin-top:16px;font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a}
.inv-footer{text-align:center;font-size:12px;color:#888;margin-top:40px;border-top:1px solid rgba(0,0,0,.06);padding-top:24px}
.inv-actions{display:flex;justify-content:center;gap:12px;margin-bottom:40px}

@media print {
    body * { visibility: hidden; }
    #invoice-content, #invoice-content * { visibility: visible; }
    #invoice-content { position: absolute; left: 0; top: 0; width: 100%; border: none; padding: 0; }
    .inv-actions { display: none; }
}
@media(max-width:700px){
    .inv-header{flex-direction:column;gap:24px}
    .inv-company{text-align:left}
    .inv-grid{grid-template-columns:1fr}
}
</style>
@endpush

@section('inner-content')
<div class="breadcrumb" style="margin-bottom:24px;font-size:12px;max-width:800px;margin-left:auto;margin-right:auto">
    <a href="{{ route('tamu.orders') }}" style="color:#6b5c47;text-decoration:none">← Back to Orders</a>
</div>

<div class="inv-wrap" id="invoice-content">
    <div class="inv-header">
        <div>
            <h1 class="inv-title">INVOICE</h1>
            <div class="inv-num">{{ $order->invoice_number ?? $order->order_code }}</div>
        </div>
        <div class="inv-company">
            <div class="inv-company-name">Tarsan Homestay</div>
            <div class="inv-company-info">Labuan Bajo, Nusa Tenggara Timur<br>tarsanhomestay@gmail.com</div>
        </div>
    </div>

    <div class="inv-grid">
        <div>
            <div class="ig-title">Booking Details</div>
            <div class="ig-row">
                <span class="ig-label">Order Date</span>
                <span class="ig-val">{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="ig-row">
                <span class="ig-label">Account Name</span>
                <span class="ig-val">{{ $order->user->name ?? 'N/A' }}</span>
            </div>
            <div class="ig-row">
                <span class="ig-label">Payment Status</span>
                <span class="ig-val {{ $order->payment_status === 'paid' ? 'ig-val-paid' : 'ig-val-unpaid' }}">
                    {{ $order->payment_status === 'paid' ? 'Paid' : 'Not Paid' }}
                </span>
            </div>
        </div>
        <div>
            <div class="ig-title">Guest Information</div>
            <div class="ig-row">
                <span class="ig-label">Guest Name</span>
                <span class="ig-val">{{ $order->guest_name ?? $order->user->name ?? 'N/A' }}</span>
            </div>
            <div class="ig-row">
                <span class="ig-label">Phone Number</span>
                <span class="ig-val">{{ $order->guest_phone ?? $order->user->phone ?? 'N/A' }}</span>
            </div>
            <div class="ig-row">
                <span class="ig-label">Email</span>
                <span class="ig-val">{{ $order->user->email ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="inv-box">
        <div class="ig-title">Stay Details</div>
        <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:20px">
            <div>
                <div style="font-size:12px;color:#666">Check-in (from 14:00 WITA)</div>
                <div style="font-size:16px;font-weight:500;color:#1a1a1a">{{ $order->check_in?->format('d M Y') ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#666">Check-out (before 12:00 WITA)</div>
                <div style="font-size:16px;font-weight:500;color:#1a1a1a">{{ $order->check_out?->format('d M Y') ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#666">Duration</div>
                <div style="font-size:16px;font-weight:500;color:#1a1a1a">{{ $order->nights ?? 1 }} Night(s)</div>
            </div>
        </div>
    </div>

    @if($order->items && $order->items->count() > 0)
    <table class="inv-table">
        <thead>
            <tr>
                <th>Room</th>
                <th class="t-center">Price/Night</th>
                <th class="t-center">Nights</th>
                <th class="t-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <div style="font-weight:500">{{ $item->room->room_name ?? 'N/A' }}</div>
                    @if($item->room && $item->room->capacity)
                        <div style="font-size:12px;color:#888;margin-top:2px">Capacity: {{ $item->room->capacity }} guests</div>
                    @endif
                </td>
                <td class="t-center">Rp {{ number_format($item->price_per_night ?? 0, 0, ',', '.') }}</td>
                <td class="t-center">{{ $item->nights ?? $order->nights ?? 1 }}</td>
                <td class="t-right font-medium">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="inv-summary">
        <div class="is-row">
            <span>Subtotal</span>
            <span class="is-val">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
        </div>
        @if($order->discount_amount ?? 0 > 0)
        <div class="is-row" style="color:#059669">
            <span>Discount</span>
            <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="is-total">
            <span>Total</span>
            <span>Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
        </div>
        @if($order->payment_method)
            <div style="text-align:right;font-size:12px;color:#888;margin-top:12px">
                Payment Method: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
            </div>
        @endif
    </div>

    <div class="inv-footer">
        This invoice is automatically generated and is valid without signature or stamp.<br>
        Thank you for choosing Tarsan Homestay.
    </div>
</div>

<div class="inv-actions">
    <button onclick="window.print()" class="btn-dark">🖨 Print Invoice</button>
    <a href="{{ route('tamu.invoice.download', $order) }}" class="btn-fill">📄 Download PDF</a>
</div>
@endsection
