@extends('layouts.tamu-inner')
@section('title', 'Booking Details – Tarsan Homestay')
@section('page-tag', 'Reservation')
@section('page-title', 'Booking Details')
@section('page-sub', 'Complete your guest information to proceed with payment')

@push('styles')
<style>
.res-grid{display:grid;grid-template-columns:1fr 400px;gap:24px;align-items:start}
.res-section{background:#fff;border:1px solid rgba(0,0,0,.07);padding:32px;margin-bottom:24px}
.res-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:20px;display:flex;justify-content:space-between;align-items:center}
.res-item{display:flex;justify-content:space-between;padding:16px 0;border-bottom:1px solid rgba(0,0,0,.06)}
.res-item:last-child{border-bottom:none;padding-bottom:0}
.res-item-main{flex:1}
.res-item-name{font-family:'Playfair Display',serif;font-size:18px;font-weight:400;color:#1a1a1a;margin-bottom:6px}
.res-item-meta{font-size:13px;color:#666}
.res-item-price{font-family:'Playfair Display',serif;font-size:18px;font-weight:400;color:#1a1a1a;text-align:right}
.res-item-remove{font-size:11px;color:#dc2626;text-decoration:underline;background:none;border:none;cursor:pointer;padding:0;margin-top:6px;font-family:'Inter',sans-serif}
.form-group{margin-bottom:20px}
.form-label{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;display:block;margin-bottom:8px}
.form-input{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:12px 16px;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .3s}
.form-input:focus{border-color:#6b5c47}
.sum-row{display:flex;justify-content:space-between;font-size:14px;color:#444;margin-bottom:12px}
.sum-total{display:flex;justify-content:space-between;align-items:center;padding-top:16px;border-top:1px solid rgba(0,0,0,.06);margin-top:16px}
.sum-total-label{font-size:12px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#1a1a1a}
.sum-total-val{font-family:'Playfair Display',serif;font-size:28px;font-weight:400;color:#1a1a1a}
@media(max-width:900px){.res-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('inner-content')
<div class="res-grid">
    {{-- LEFT --}}
    <div>
        <div class="res-section">
            <h2 class="res-title">
                <span>Selected Rooms</span>
                <a href="{{ route('tamu.booking.index') }}" class="btn-dark" style="font-size:11px;padding:8px 16px">+ Add Room</a>
            </h2>
            @forelse($cart as $item)
                <div class="res-item">
                    <div class="res-item-main">
                        <div class="res-item-name">{{ $item['room_name'] }}</div>
                        <div class="res-item-meta">
                            {{ \Carbon\Carbon::parse($item['check_in'])->format('d M Y') }} – {{ \Carbon\Carbon::parse($item['check_out'])->format('d M Y') }}
                            <br>
                            {{ $item['nights'] }} nights
                        </div>
                    </div>
                    <div style="text-align:right">
                        <div class="res-item-price">Rp {{ number_format($item['subtotal']) }}</div>
                        <form method="POST" action="{{ route('tamu.booking.remove', $item['room_id']) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="res-item-remove">Remove</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="empty" style="padding:40px 0">
                    <div class="empty-icon">🛒</div>
                    <p class="empty-sub">No rooms selected</p>
                </div>
            @endforelse
        </div>

        <div class="res-section">
            <h2 class="res-title">Guest Information</h2>
            <form method="POST" action="{{ route('tamu.reservation.guest') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Guest Name *</label>
                    <input type="text" name="name" class="form-input" value="{{ session('guest.name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" class="form-input" value="{{ session('guest.phone') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Voucher Code (Optional)</label>
                    <input type="text" name="voucher" class="form-input" value="{{ session('voucher.code') }}" placeholder="Enter code...">
                    @error('voucher')
                        <p style="color:#dc2626;font-size:12px;margin-top:6px">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn-dark" style="width:100%">Save Guest Data</button>
            </form>
        </div>
    </div>

    {{-- RIGHT --}}
    <div>
        <div class="res-section" style="position:sticky;top:84px">
            <h2 class="res-title">Summary</h2>
            
            @php
                $subtotal = $grandTotal;
                $voucherDiscount = session('voucher.discount', 0);
                $finalTotal = max($subtotal - $voucherDiscount, 0);
                session(['payment' => ['subtotal' => $subtotal, 'discount' => $voucherDiscount, 'final_total' => $finalTotal]]);
            @endphp

            <div class="sum-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($subtotal) }}</span>
            </div>

            @if($voucherDiscount > 0)
            <div class="sum-row" style="color:#059669">
                <span>Voucher Discount</span>
                <span>- Rp {{ number_format($voucherDiscount) }}</span>
            </div>
            @endif

            <div class="sum-total">
                <span class="sum-total-label">Total</span>
                <span class="sum-total-val">Rp {{ number_format($finalTotal) }}</span>
            </div>

            @php $guestReady = session()->has('guest.name') && session()->has('guest.phone'); @endphp

            @if($guestReady && count($cart) > 0)
                <a href="{{ route('tamu.payment.index') }}" class="btn-fill" style="display:block;text-align:center;width:100%;margin-top:24px">Continue to Payment</a>
            @else
                <button disabled class="btn-dark" style="display:block;text-align:center;width:100%;margin-top:24px;opacity:0.5;cursor:not-allowed">
                    {{ count($cart) == 0 ? 'Cart is Empty' : 'Fill Guest Data First' }}
                </button>
            @endif
        </div>
    </div>
</div>
@endsection
