@extends('layouts.tamu-inner')
@section('title', 'Our Rooms – Tarsan Homestay')
@section('page-tag', 'Accommodation')
@section('page-title', 'Rooms & Suites')
@section('page-sub', 'Choose the perfect room for your stay in Labuan Bajo')

@push('styles')
<style>
.room-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:2px}
.room-card{background:#fff;border:1px solid rgba(0,0,0,.07);display:flex;flex-direction:column;overflow:hidden;transition:box-shadow .3s,border-color .3s}
.room-card:hover{box-shadow:0 8px 40px rgba(0,0,0,.1);border-color:rgba(0,0,0,.14)}
.room-img{position:relative;height:260px;overflow:hidden;flex-shrink:0}
.room-img img{width:100%;height:100%;object-fit:cover;transition:transform .7s}
.room-card:hover .room-img img{transform:scale(1.05)}
.room-price{position:absolute;bottom:14px;left:14px;background:#1a1a1a;color:#fff;padding:5px 12px;font-size:12px;font-weight:600;letter-spacing:.04em}
.room-body{padding:24px;flex:1;display:flex;flex-direction:column}
.room-name{font-family:'Playfair Display',serif;font-size:21px;font-weight:400;color:#1a1a1a;margin-bottom:8px;line-height:1.2}
.room-meta{display:flex;gap:18px;font-size:12px;color:#888;margin-bottom:12px}
.room-tags{display:flex;flex-wrap:wrap;gap:5px;margin-bottom:14px}
.room-tag{padding:3px 9px;background:#f4f0e6;color:#6b5c47;font-size:11px}
.room-desc{font-size:13px;font-weight:300;color:#777;line-height:1.75;flex:1;margin-bottom:18px;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden}
.room-actions{display:flex;gap:8px;padding-top:16px;border-top:1px solid rgba(0,0,0,.06)}
.room-actions a{flex:1;padding:11px 0;text-align:center;font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:all .3s}
.ra-view{border:1px solid #1a1a1a;color:#1a1a1a}
.ra-view:hover{background:#1a1a1a;color:#fff}
.ra-book{border:1px solid #6b5c47;background:#6b5c47;color:#fff}
.ra-book:hover{background:#5a4d3a;border-color:#5a4d3a}
.no-img{width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f4f0e6;color:#aaa;font-size:13px}
@media(max-width:900px){
  .room-grid{grid-template-columns:1fr}
  .fg-filter{grid-template-columns:1fr 1fr!important}
}
@media(max-width:600px){
  .fg-filter{grid-template-columns:1fr!important}
}
</style>
@endpush

@section('inner-content')
{{-- FILTER --}}
<div class="filter-bar">
    <form method="GET" action="{{ route('kamar.index') }}">
        <div class="fg-filter" style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto;gap:16px;align-items:end">
            <div>
                <label>Search Room</label>
                <input type="text" name="search" placeholder="Room name..." value="{{ request('search') }}">
            </div>
            <div>
                <label>Facilities</label>
                <select name="facility">
                    <option value="">All Facilities</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->slug }}" {{ request('facility') == $facility->slug ? 'selected' : '' }}>{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Min Price</label>
                <input type="number" name="price_min" placeholder="0" value="{{ request('price_min') }}">
            </div>
            <div>
                <label>Max Price</label>
                <input type="number" name="price_max" placeholder="10.000.000" value="{{ request('price_max') }}">
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" class="btn-fill">Filter</button>
                <a href="{{ route('kamar.index') }}" class="btn-dark">Reset</a>
            </div>
        </div>
    </form>
</div>

@if($rooms->isEmpty())
<div class="empty">
    <div class="empty-icon">🛏</div>
    <h3 class="empty-title">No Rooms Found</h3>
    <p class="empty-sub">Try adjusting your search filters</p>
    <a href="{{ route('kamar.index') }}" class="btn-fill">Clear Filters</a>
</div>
@else
<div class="room-grid">
    @foreach($rooms as $room)
    <div class="room-card">
        <div class="room-img">
            @if($room->images->count() > 0)
                <img src="{{ image_url($room->images->first()->image) }}" alt="{{ $room->room_name }}">
            @else
                <div class="no-img">No image available</div>
            @endif
            <div class="room-price">Rp {{ number_format($room->price_per_night, 0, ',', '.') }} / night</div>
        </div>
        <div class="room-body">
            <h3 class="room-name">{{ $room->room_name }}</h3>
            <div class="room-meta">
                <span>👤 {{ $room->capacity }} guests</span>
                <span>🏠 {{ $room->total_rooms }} unit</span>
            </div>
            @if($room->facility_names->isNotEmpty())
            <div class="room-tags">
                @foreach($room->facility_names->take(3) as $f)
                    <span class="room-tag">{{ $f }}</span>
                @endforeach
                @if($room->facility_names->count() > 3)
                    <span class="room-tag">+{{ $room->facility_names->count()-3 }}</span>
                @endif
            </div>
            @endif
            <p class="room-desc">{{ $room->description }}</p>
            <div class="room-actions">
                <a href="{{ route('kamar.show', $room) }}" class="ra-view">View Details</a>
                @auth
                    @if(auth()->user()->role === 'tamu')
                        <a href="{{ route('tamu.booking.index') }}?room_id={{ $room->id }}" class="ra-book">Book</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="ra-book">Book</a>
                @endauth
            </div>
        </div>
    </div>
    @endforeach
</div>
{{ $rooms->links() }}
@endif
@endsection
