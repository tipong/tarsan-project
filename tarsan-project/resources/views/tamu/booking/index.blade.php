@extends('layouts.tamu-inner')
@section('title', 'Book a Room – Tarsan Homestay')
@section('page-tag', 'Reservation')
@section('page-title', 'Book a Room')
@section('page-sub', 'Select your dates and add rooms to your booking cart')

@push('styles')
<style>
.booking-wrap{display:grid;grid-template-columns:1fr 320px;gap:2px;align-items:start}
.room-list{display:flex;flex-direction:column;gap:2px}
.broom-card{background:#fff;border:1px solid rgba(0,0,0,.07);display:grid;grid-template-columns:200px 1fr auto;gap:0;transition:box-shadow .3s;overflow:hidden}
.broom-card.unavailable{opacity:.55;pointer-events:none}
.broom-card:hover{box-shadow:0 4px 24px rgba(0,0,0,.08)}
.broom-img{position:relative;height:180px;overflow:hidden;flex-shrink:0}
.broom-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.broom-card:hover .broom-img img{transform:scale(1.05)}
.broom-avail{position:absolute;top:10px;left:10px;padding:4px 10px;font-size:10px;font-weight:700;letter-spacing:.1em;text-transform:uppercase}
.av-yes{background:#059669;color:#fff}
.av-no{background:#dc2626;color:#fff}
.broom-body{padding:20px 24px;display:flex;flex-direction:column;justify-content:center}
.broom-name{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:8px}
.broom-desc{font-size:13px;font-weight:300;color:#888;line-height:1.65;margin-bottom:12px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.broom-meta{display:flex;gap:16px;font-size:12px;color:#6b5c47}
.broom-tags{display:flex;flex-wrap:wrap;gap:5px;margin-top:10px}
.broom-tag{padding:3px 9px;background:#f4f0e6;color:#6b5c47;font-size:11px}
.broom-action{padding:20px 24px;display:flex;flex-direction:column;justify-content:center;align-items:flex-end;gap:10px;border-left:1px solid rgba(0,0,0,.06)}
.broom-price{font-family:'Playfair Display',serif;font-size:22px;font-weight:400;color:#1a1a1a;text-align:right}
.broom-price-sub{font-size:11px;color:#888;margin-top:-4px;text-align:right}
.no-img{width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f4f0e6;color:#888;font-size:12px}
/* SIDEBAR */
.booking-sidebar{background:#fff;border:1px solid rgba(0,0,0,.07);padding:28px;position:sticky;top:84px}
.sidebar-title{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:6px}
.sidebar-sub{font-size:12px;font-weight:300;color:#888;margin-bottom:24px}
.cart-empty{text-align:center;padding:32px 16px}
.cart-empty-icon{font-size:36px;opacity:.3;margin-bottom:10px}
.cart-empty-text{font-size:13px;color:#aaa}
.cart-item{padding:14px 0;border-bottom:1px solid rgba(0,0,0,.06)}
.cart-item-name{font-size:14px;font-weight:500;color:#1a1a1a;margin-bottom:4px}
.cart-item-nights{font-size:12px;color:#888}
.cart-item-price{font-size:14px;font-weight:600;color:#1a1a1a;margin-top:6px}
.cart-item-remove{font-size:11px;color:#dc2626;cursor:pointer;background:none;border:none;font-family:'Inter',sans-serif;padding:0;margin-top:4px;text-decoration:underline}
.cart-total-row{display:flex;justify-content:space-between;align-items:center;padding:20px 0 20px}
.cart-total-label{font-size:12px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65}
.cart-total-val{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a}
@media(max-width:900px){
  .booking-wrap{grid-template-columns:1fr}
  .broom-card{grid-template-columns:1fr}
  .broom-img{height:200px}
  .broom-action{border-left:none;border-top:1px solid rgba(0,0,0,.06);flex-direction:row;align-items:center;justify-content:space-between}
  .broom-price{text-align:left}
  .broom-price-sub{text-align:left}
}
</style>
@endpush

@section('inner-content')
{{-- FILTER --}}
<div class="filter-bar" style="margin-bottom:28px">
    <form method="POST" action="{{ route('tamu.booking.search') }}">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:16px;align-items:end" class="filter-grid">
            <div>
                <label>Check In</label>
                <input type="date" name="check_in" value="{{ request('check_in') }}" required>
            </div>
            <div>
                <label>Check Out</label>
                <input type="date" name="check_out" value="{{ request('check_out') }}" required>
            </div>
            <div>
                <label>Room Name</label>
                <input type="text" name="room_search" placeholder="Search..." value="{{ request('room_search') }}">
            </div>
            <div>
                <label>Facilities</label>
                <select name="facility">
                    <option value="">All</option>
                    @foreach($facilities as $f)
                        <option value="{{ $f->slug }}" {{ request('facility') == $f->slug ? 'selected' : '' }}>{{ $f->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn-fill" style="white-space:nowrap">Search</button>
                <a href="{{ route('tamu.booking.index') }}" class="btn-dark" style="white-space:nowrap">Reset</a>
            </div>
        </div>
    </form>
</div>

<div class="booking-wrap">
    {{-- ROOM LIST --}}
    <div class="room-list">
        @forelse($rooms as $room)
        <div class="broom-card {{ isset($room->is_available) && !$room->is_available ? 'unavailable' : '' }}">
            <div class="broom-img">
                @if($room->images->count() > 0)
                    <img src="{{ asset('storage/'.$room->images->first()->image) }}" alt="{{ $room->room_name }}">
                @else
                    <div class="no-img">No image</div>
                @endif
                @if(isset($room->is_available))
                    <span class="broom-avail {{ $room->is_available ? 'av-yes' : 'av-no' }}">
                        {{ $room->is_available ? 'Available' : 'Fully Booked' }}
                    </span>
                @endif
            </div>
            <div class="broom-body">
                <h3 class="broom-name">{{ $room->room_name }}</h3>
                <p class="broom-desc">{{ $room->description }}</p>
                <div class="broom-meta">
                    <span>👤 {{ $room->capacity }} guests</span>
                </div>
                @if($room->facility_names->isNotEmpty())
                <div class="broom-tags">
                    @foreach($room->facility_names->take(2) as $f)
                        <span class="broom-tag">{{ $f }}</span>
                    @endforeach
                    @if($room->facility_names->count() > 2)
                        <span class="broom-tag">+{{ $room->facility_names->count()-2 }}</span>
                    @endif
                </div>
                @endif
            </div>
            <div class="broom-action">
                <div>
                    <div class="broom-price">Rp {{ number_format($room->price_per_night) }}</div>
                    <div class="broom-price-sub">per night</div>
                </div>
                @php $hasDate = session()->has('booking_filter'); @endphp
                @if($hasDate && isset($room->is_available) && $room->is_available)
                    <form method="POST" action="{{ route('tamu.booking.add') }}">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        <input type="hidden" name="check_in" value="{{ session('booking_filter.check_in') }}">
                        <input type="hidden" name="check_out" value="{{ session('booking_filter.check_out') }}">
                        <button type="submit" class="btn-fill" style="white-space:nowrap">+ Add</button>
                    </form>
                @elseif($hasDate && isset($room->is_available) && !$room->is_available)
                    <button disabled class="btn-dark" style="cursor:not-allowed;opacity:.5">Not Available</button>
                @else
                    <button disabled class="btn-dark" style="cursor:not-allowed;opacity:.5">Select Date First</button>
                @endif
            </div>
        </div>
        @empty
        <div class="empty">
            <div class="empty-icon">🛏</div>
            <h3 class="empty-title">No Rooms Available</h3>
            <p class="empty-sub">Try different dates or filters</p>
        </div>
        @endforelse
    </div>

    {{-- SIDEBAR CART --}}
    <div class="booking-sidebar">
        <div class="sidebar-title">Booking <em style="font-style:italic;color:#6b5c47">Summary</em></div>
        <p class="sidebar-sub">Items in your cart</p>
        @php
            $cart = session('cart', []);
            $grandTotal = array_sum(array_column($cart, 'subtotal'));
        @endphp
        @if(count($cart))
            <div style="max-height:300px;overflow-y:auto">
                @foreach($cart as $roomId => $item)
                <div class="cart-item">
                    <div class="cart-item-name">{{ $item['room_name'] }}</div>
                    <div class="cart-item-nights">{{ $item['nights'] }} nights</div>
                    <div class="cart-item-price">Rp {{ number_format($item['subtotal']) }}</div>
                    <form method="POST" action="{{ route('tamu.booking.remove', $roomId) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="cart-item-remove">Remove</button>
                    </form>
                </div>
                @endforeach
            </div>
            <div class="cart-total-row">
                <span class="cart-total-label">Total</span>
                <span class="cart-total-val">Rp {{ number_format($grandTotal) }}</span>
            </div>
            <a href="{{ route('tamu.reservation.index') }}" class="btn-fill" style="display:block;text-align:center;width:100%">Continue to Booking</a>
        @else
            <div class="cart-empty">
                <div class="cart-empty-icon">🛒</div>
                <p class="cart-empty-text">No rooms selected yet.<br>Search and add rooms above.</p>
            </div>
        @endif
    </div>
</div>
@endsection
