@extends('layouts.tamu-inner')
@section('title', $room->room_name . ' – Tarsan Homestay')
@section('page-tag', 'Accommodation')
@section('page-title', $room->room_name)
@section('page-sub', 'Rp ' . number_format($room->price_per_night, 0, ',', '.') . ' per night · ' . $room->capacity . ' guests · ' . $room->total_rooms . ' unit')

@push('styles')
<style>
.show-grid{display:grid;grid-template-columns:1fr 360px;gap:2px;align-items:start}
.show-main{display:flex;flex-direction:column;gap:2px}
.main-img{height:460px;overflow:hidden;background:#f4f0e6;position:relative}
.main-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s}
.main-img:hover img{transform:scale(1.02)}
.thumb-row{display:flex;gap:2px}
.thumb{flex:1;height:110px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:border-color .3s}
.thumb:hover,.thumb.active{border-color:#6b5c47}
.thumb img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.thumb:hover img{transform:scale(1.06)}
.show-sidebar{position:sticky;top:84px;display:flex;flex-direction:column;gap:2px}
.sidebar-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:28px}
.sb-label{font-size:10px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:#8a7a65;margin-bottom:10px;display:block}
.sb-price{font-family:'Playfair Display',serif;font-size:36px;font-weight:400;color:#1a1a1a;line-height:1;margin-bottom:4px}
.sb-price-sub{font-size:12px;color:#aaa;margin-bottom:24px}
.fac-list{display:flex;flex-direction:column;gap:8px}
.fac-item{display:flex;align-items:center;gap:10px;font-size:13px;color:#444}
.fac-item::before{content:'—';color:#6b5c47;font-size:12px;flex-shrink:0}
.desc-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:36px;margin-top:2px}
.desc-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:18px}
.desc-text{font-size:15px;font-weight:300;color:#555;line-height:1.9}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px}
.info-item{}
.info-label{font-size:10px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#8a7a65;margin-bottom:5px}
.info-val{font-family:'Playfair Display',serif;font-size:18px;font-weight:400;color:#1a1a1a}
.breadcrumb{display:flex;align-items:center;gap:8px;margin-bottom:28px;font-size:12px;color:#aaa}
.breadcrumb a{color:#6b5c47;text-decoration:none;transition:color .3s}
.breadcrumb a:hover{color:#1a1a1a}
@media(max-width:900px){
  .show-grid{grid-template-columns:1fr}
  .show-sidebar{position:static}
  .thumb-row{overflow-x:auto}
  .thumb{min-width:100px}
}
</style>
@endpush

@section('inner-content')
<div class="breadcrumb">
    <a href="{{ route('kamar.index') }}">← All Rooms</a>
    <span>/</span>
    <span style="color:#2a2a2a">{{ $room->room_name }}</span>
</div>

<div class="show-grid">
    {{-- LEFT: IMAGES + DESCRIPTION --}}
    <div class="show-main">
        <div class="main-img">
            @if($room->images->count() > 0)
                <img src="{{ asset('storage/'.$room->images->first()->image) }}" alt="{{ $room->room_name }}" id="mainImage">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:14px">No image available</div>
            @endif
        </div>

        @if($room->images->count() > 1)
        <div class="thumb-row">
            @foreach($room->images as $idx => $image)
                <div class="thumb {{ $idx === 0 ? 'active' : '' }}" onclick="switchImage('{{ asset('storage/'.$image->image) }}', this)">
                    <img src="{{ asset('storage/'.$image->image) }}" alt="Gallery">
                </div>
            @endforeach
        </div>
        @endif

        <div class="desc-box">
            <h2 class="desc-title">About This Room</h2>
            <p class="desc-text">{{ $room->description }}</p>
        </div>
    </div>

    {{-- RIGHT: SIDEBAR --}}
    <div class="show-sidebar">
        <div class="sidebar-box">
            <span class="sb-label">Price Per Night</span>
            <div class="sb-price">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</div>
            <div class="sb-price-sub">per night, excluding tax</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Capacity</div>
                    <div class="info-val">{{ $room->capacity }} guests</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Units</div>
                    <div class="info-val">{{ $room->total_rooms }} rooms</div>
                </div>
            </div>

            @auth
                @if(auth()->user()->role === 'tamu')
                    <a href="{{ route('tamu.booking.index') }}?room_id={{ $room->id }}" class="btn-fill" style="display:block;text-align:center;width:100%;margin-bottom:8px">Book This Room</a>
                @else
                    <div style="padding:12px 16px;background:#fff5f5;border-left:3px solid #dc2626;font-size:13px;color:#991b1b;margin-bottom:8px">Only guests can book rooms</div>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-fill" style="display:block;text-align:center;width:100%;margin-bottom:8px">Login to Book</a>
            @endauth
            <a href="{{ route('kamar.index') }}" class="btn-dark" style="display:block;text-align:center;width:100%">Back to Rooms</a>
        </div>

        @if($room->facility_names->isNotEmpty())
        <div class="sidebar-box">
            <span class="sb-label">Room Facilities</span>
            <div class="fac-list">
                @foreach($room->facility_names as $facilityName)
                    <div class="fac-item">{{ $facilityName }}</div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchImage(src, el){
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumb').forEach(t=>t.classList.remove('active'));
    el.classList.add('active');
}
</script>
@endpush
