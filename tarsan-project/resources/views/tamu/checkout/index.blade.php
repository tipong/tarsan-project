@extends('layouts.tamu-inner')
@section('title', 'Checkout – Tarsan Homestay')
@section('page-tag', 'Reservation')
@section('page-title', 'Checkout <em>Confirmation</em>')
@section('page-sub', 'Review your booking details before confirming')

@push('styles')
<style>
.co-grid{display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start}
.co-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:32px;margin-bottom:24px}
.co-title{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:24px}
.co-room{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:8px}
.co-room-sub{font-size:13px;color:#666;margin-bottom:24px}
.co-grid-inner{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;padding-top:24px;border-top:1px solid rgba(0,0,0,.06)}
.co-item{display:flex;flex-direction:column;gap:4px}
.co-label{font-size:10px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65}
.co-val{font-size:14px;color:#1a1a1a;font-weight:500}
.co-guest{padding-top:24px;border-top:1px solid rgba(0,0,0,.06)}
.co-sum-row{display:flex;justify-content:space-between;margin-bottom:12px;font-size:14px;color:#444}
.co-sum-total{display:flex;justify-content:space-between;align-items:center;padding-top:16px;border-top:1px solid rgba(0,0,0,.06);margin-top:16px}
.cst-label{font-size:12px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#1a1a1a}
.cst-val{font-family:'Playfair Display',serif;font-size:28px;font-weight:400;color:#1a1a1a}
@media(max-width:900px){.co-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('inner-content')
<div class="co-grid">
    {{-- LEFT: BOOKING DETAIL --}}
    <div>
        <div class="co-box">
            <h2 class="co-title">Booking Detail</h2>
            
            <div class="co-room">{{ $order->items[0]->room->room_name }}</div>
            <div class="co-room-sub">Capacity: {{ $room->capacity }} Persons</div>

            <div class="co-grid-inner">
                <div class="co-item">
                    <span class="co-label">Check In</span>
                    <span class="co-val">{{ $order->check_in->format('d M Y') }}</span>
                </div>
                <div class="co-item">
                    <span class="co-label">Check Out</span>
                    <span class="co-val">{{ $order->check_out->format('d M Y') }}</span>
                </div>
                <div class="co-item">
                    <span class="co-label">Nights</span>
                    <span class="co-val">{{ $order->nights }}</span>
                </div>
                <div class="co-item">
                    <span class="co-label">Guests</span>
                    <span class="co-val">{{ $guests }} Person(s)</span>
                </div>
            </div>

            <div class="co-guest">
                <div class="co-label" style="margin-bottom:12px">Guest Information</div>
                <div class="co-val">Name: {{ auth()->user()->name }}</div>
                <div class="co-val" style="margin-top:4px">Email: {{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>

    {{-- RIGHT: PRICE SUMMARY --}}
    <div>
        <div class="co-box" style="position:sticky;top:84px">
            <h2 class="co-title">Price Summary</h2>
            
            <div class="co-sum-row">
                <span>Room Price</span>
                <span>Rp {{ number_format($room->price_per_night) }}</span>
            </div>
            <div class="co-sum-row">
                <span>Nights</span>
                <span>{{ $nights }}</span>
            </div>
            
            <div class="co-sum-total">
                <span class="cst-label">Total</span>
                <span class="cst-val">Rp {{ number_format($order->total_price) }}</span>
            </div>

            <form method="POST" action="{{ route('tamu.checkout.confirm') }}" style="margin-top:24px">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="check_in" value="{{ $check_in }}">
                <input type="hidden" name="check_out" value="{{ $check_out }}">
                <input type="hidden" name="guests" value="{{ $guests }}">
                <input type="hidden" name="total" value="{{ $total }}">
                <button type="submit" class="btn-fill" style="width:100%;text-align:center">Confirm Booking</button>
            </form>

            <div style="text-align:center;margin-top:16px">
                <a href="{{ route('tamu.booking.index') }}" style="font-size:12px;color:#888;text-decoration:none">← Back to Booking</a>
            </div>
        </div>
    </div>
</div>
@endsection
