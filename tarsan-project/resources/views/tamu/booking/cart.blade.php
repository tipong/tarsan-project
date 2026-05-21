@extends('layouts.tamu-inner')
@section('title', 'Your Cart – Tarsan Homestay')
@section('page-tag', 'Reservation')
@section('page-title', 'Your <em>Cart</em>')
@section('page-sub', 'Review the rooms you have selected')

@push('styles')
<style>
.cart-wrap{background:#fff;border:1px solid rgba(0,0,0,.07);padding:40px;max-width:800px;margin:0 auto}
.cart-item{display:flex;justify-content:space-between;align-items:center;padding:24px 0;border-bottom:1px solid rgba(0,0,0,.06)}
.cart-item:last-of-type{border-bottom:none}
.ci-info{flex:1}
.ci-name{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:6px}
.ci-meta{font-size:13px;color:#666}
.ci-price{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;text-align:right}
.cart-total{display:flex;justify-content:space-between;align-items:center;padding-top:32px;border-top:1px solid rgba(0,0,0,.06);margin-top:16px}
.ct-label{font-size:14px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65}
.ct-val{font-family:'Playfair Display',serif;font-size:32px;font-weight:400;color:#1a1a1a}
.cart-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:40px}
</style>
@endpush

@section('inner-content')
<div class="cart-wrap">
    @php $total = 0; @endphp

    @forelse(session('cart', []) as $item)
        @php $total += $item['subtotal']; @endphp
        <div class="cart-item">
            <div class="ci-info">
                <div class="ci-name">{{ $item['room_name'] }}</div>
                <div class="ci-meta">
                    {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} → {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}<br>
                    {{ $item['nights'] }} nights
                </div>
            </div>
            <div class="ci-price">Rp {{ number_format($item['subtotal']) }}</div>
        </div>
    @empty
        <div class="empty" style="padding:60px 0">
            <div class="empty-icon">🛒</div>
            <h3 class="empty-title">Your Cart is Empty</h3>
            <p class="empty-sub">Add some rooms to proceed</p>
        </div>
    @endforelse

    @if($total > 0)
    <div class="cart-total">
        <span class="ct-label">Total</span>
        <span class="ct-val">Rp {{ number_format($total) }}</span>
    </div>
    <div class="cart-actions">
        <a href="{{ route('kamar.index') }}" class="btn-dark">Add More Rooms</a>
        <a href="{{ route('tamu.checkout.index') }}" class="btn-fill">Proceed to Checkout</a>
    </div>
    @endif
</div>
@endsection