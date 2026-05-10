@extends('tamu.layouts.app')

@section('content')
<h2>Payment</h2>

<p>Total: Rp {{ number_format($order->total_price) }}</p>

<button id="pay-button"
    class="bg-slate-900 text-white px-6 py-2 rounded">
    Pay Now
</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}');
};
</script>
@endsection