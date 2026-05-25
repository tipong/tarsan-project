@extends('layouts.tamu-inner')
@section('title', 'Payment – Tarsan Homestay')
@section('page-tag', 'Payment')
@section('page-title', 'Payment Confirmation')
@section('page-sub', 'Review your order before proceeding to secure payment')

@push('styles')
<style>
.pay-grid{display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start}
.pay-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:32px;margin-bottom:24px}
.pay-title{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:20px}
.pay-item{display:flex;justify-content:space-between;padding:14px 0;border-bottom:1px solid rgba(0,0,0,.06)}
.pay-item:last-child{border-bottom:none;padding-bottom:0}
.pi-name{font-size:14px;font-weight:500;color:#1a1a1a;margin-bottom:4px}
.pi-meta{font-size:12px;color:#666}
.pi-price{font-family:'Playfair Display',serif;font-size:16px;font-weight:400;color:#1a1a1a;text-align:right}
.pay-total{display:flex;justify-content:space-between;align-items:center;padding-top:20px;border-top:1px solid rgba(0,0,0,.06);margin-top:20px}
.pt-label{font-size:12px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#1a1a1a}
.pt-val{font-family:'Playfair Display',serif;font-size:28px;font-weight:400;color:#1a1a1a}
.g-row{margin-bottom:12px}
.g-label{font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#8a7a65;margin-bottom:4px}
.g-val{font-size:14px;color:#1a1a1a}
.pm-list{margin-bottom:24px;font-size:13px;color:#555;line-height:1.8}
.pm-list ul{padding-left:0;list-style:none;margin-top:10px}
.pm-list li{display:flex;align-items:center;gap:8px}
.pm-list li::before{content:'✓';color:#6b5c47;font-weight:bold}
.secure-note{font-size:11px;color:#888;text-align:center;margin-top:16px;letter-spacing:.05em}
@media(max-width:900px){.pay-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('inner-content')
<div class="pay-grid">
    {{-- LEFT --}}
    <div>
        <div class="pay-box">
            <h2 class="pay-title">Order Summary</h2>
            @foreach($cart as $item)
                <div class="pay-item">
                    <div>
                        <div class="pi-name">{{ $item['room_name'] }}</div>
                        <div class="pi-meta">
                            {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} – {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}<br>
                            {{ $item['nights'] }} nights
                        </div>
                    </div>
                    <div>
                        <div class="pi-price">Rp {{ number_format($item['subtotal']) }}</div>
                        <div class="pi-meta" style="text-align:right;margin-top:2px">Rp {{ number_format($item['price'] ?? 0) }}/night</div>
                    </div>
                </div>
            @endforeach
            <div class="pay-total">
                <span class="pt-label">Total Payment</span>
                <span class="pt-val">Rp {{ number_format($finalTotal) }}</span>
            </div>
        </div>

        <div class="pay-box">
            <h2 class="pay-title">Guest Data</h2>
            <div class="g-row">
                <div class="g-label">Guest Name</div>
                <div class="g-val">{{ session('guest.name', 'N/A') }}</div>
            </div>
            <div class="g-row">
                <div class="g-label">Phone Number</div>
                <div class="g-val">{{ session('guest.phone', 'N/A') }}</div>
            </div>
            <div class="g-row">
                <div class="g-label">Email</div>
                <div class="g-val">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>

    {{-- RIGHT --}}
    <div>
        <div class="pay-box" style="position:sticky;top:84px">
            <h2 class="pay-title">Payment Methods</h2>
            <div class="pm-list">
                Powered by <strong>Midtrans</strong>. We accept:
                <ul>
                    <li>Credit / Debit Card</li>
                    <li>Bank Transfer (Virtual Account)</li>
                    <li>E-Wallet (GoPay, OVO, ShopeePay)</li>
                    <li>QRIS</li>
                </ul>
            </div>

            <button id="pay-button" class="btn-fill" style="width:100%;text-align:center;margin-bottom:12px">💳 Continue Payment</button>

            <form action="{{ route('tamu.payment.cancel', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-dark" style="width:100%;text-align:center;background:transparent;border:1px solid #dc2626;color:#dc2626" onclick="return confirm('Cancel this booking? The room will be released.')">
                    ❌ Cancel Booking
                </button>
            </form>
            
            <div class="secure-note">🔒 Secured by Midtrans</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const orderBaseUrl = "{{ url('/tamu/orders') }}";
const paymentOrderBaseUrl = "{{ url('/tamu/payment/orders') }}";

async function syncPaymentStatus(orderId, result = {}) {
    const response = await fetch(`${paymentOrderBaseUrl}/${orderId}/sync`, {
        method: "POST",
        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}","Accept": "application/json","Content-Type": "application/json"},
        body: JSON.stringify(result)
    });
    const data = await response.json();
    if (!response.ok) throw new Error(data.error ?? 'Failed to sync payment status.');
    return data;
}

document.getElementById('pay-button').addEventListener('click', async function () {
    const button = this;
    button.disabled = true;
    button.innerHTML = '⏳ Processing...';

    try {
        const response = await fetch("{{ route('tamu.payment.pay') }}", {
            method: "POST",
            headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}","Accept": "application/json","Content-Type": "application/json"}
        });

        if (!response.ok) {
            let serverMessage = 'An error occurred. Please try again.';
            try {
                const errorData = await response.json();
                serverMessage = errorData.error ?? serverMessage;
            } catch (e) {}
            alert('Error: ' + serverMessage);
            button.disabled = false;
            button.innerHTML = '💳 Continue Payment';
            return;
        }

        const data = await response.json();
        if (!data.snap_token) {
            alert('Error: ' + (data.error ?? 'Failed to create payment token'));
            button.disabled = false;
            button.innerHTML = '💳 Continue Payment';
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);
                    alert('Payment successful!');
                    window.location.href = "{{ route('tamu.payment.success') }}";
                } catch (e) {
                    button.disabled = false;
                    button.innerHTML = '💳 Continue Payment';
                    alert('Error: ' + e.message);
                }
            },
            onPending: async function (result) {
                try {
                    await syncPaymentStatus(data.order_id, result);
                    alert('Your payment is being processed.');
                    window.location.href = `${orderBaseUrl}/${data.order_id}`;
                } catch (e) {
                    button.disabled = false;
                    button.innerHTML = '💳 Continue Payment';
                    alert('Error: ' + e.message);
                }
            },
            onError: function () {
                alert('Payment failed. Please try again.');
                button.disabled = false;
                button.innerHTML = '💳 Continue Payment';
            },
            onClose: function () {
                button.disabled = false;
                button.innerHTML = '💳 Continue Payment';
            }
        });
    } catch (error) {
        alert('An error occurred. Please try again.');
        button.disabled = false;
        button.innerHTML = '💳 Continue Payment';
    }
});
</script>
@endpush
