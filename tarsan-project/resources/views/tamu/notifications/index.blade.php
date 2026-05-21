@extends('layouts.tamu-inner')
@section('title', 'Notifications – Tarsan Homestay')
@section('page-tag', 'Account')
@section('page-title', 'My Notifications')
@section('page-sub', 'Stay updated with your booking and payment status')

@push('styles')
<style>
.notif-header{display:flex;justify-content:flex-end;margin-bottom:28px}
.notif-card{background:#fff;border:1px solid rgba(0,0,0,.07);padding:24px 28px;margin-bottom:2px;display:flex;gap:20px;align-items:flex-start;transition:box-shadow .3s}
.notif-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
.notif-card.unread{border-left:3px solid #6b5c47}
.notif-dot{width:8px;height:8px;border-radius:50%;background:#6b5c47;flex-shrink:0;margin-top:6px}
.notif-dot.read{background:transparent;border:1px solid rgba(0,0,0,.15)}
.notif-body{flex:1}
.notif-title-row{display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap}
.notif-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:400;color:#1a1a1a}
.notif-msg{font-size:14px;font-weight:300;color:#666;line-height:1.7;margin-bottom:12px}
.notif-meta{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
.notif-time{font-size:12px;color:#aaa;letter-spacing:.03em}
.notif-order-link{font-size:12px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:#6b5c47;text-decoration:none;border-bottom:1px solid rgba(107,92,71,.3);padding-bottom:1px;transition:all .3s}
.notif-order-link:hover{color:#1a1a1a;border-color:#1a1a1a}
.notif-action{flex-shrink:0}
.notif-mark-btn{padding:7px 16px;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;border:1px solid rgba(0,0,0,.12);color:#555;background:transparent;cursor:pointer;font-family:'Inter',sans-serif;transition:all .3s}
.notif-mark-btn:hover{border-color:#1a1a1a;color:#1a1a1a}
</style>
@endpush

@section('inner-content')
<div class="notif-header">
    <button onclick="markAllAsRead()" class="btn-fill">✓ Mark All as Read</button>
</div>

@if($notifications->isEmpty())
<div class="empty">
    <div class="empty-icon">🔔</div>
    <h3 class="empty-title">No Notifications</h3>
    <p class="empty-sub">You're all caught up! New notifications will appear here.</p>
</div>
@else
<div>
    @foreach($notifications as $notification)
    <div class="notif-card {{ !$notification->read_at ? 'unread' : '' }}">
        <div class="notif-dot {{ $notification->read_at ? 'read' : '' }}"></div>
        <div class="notif-body">
            <div class="notif-title-row">
                <h3 class="notif-title">{{ $notification->title }}</h3>
                @if(!$notification->read_at)
                    <span class="badge badge-new">New</span>
                @endif
                <span class="badge" style="background:#f4f0e6;color:#6b5c47">
                    @if($notification->type === 'booking') 📅 Booking
                    @elseif($notification->type === 'payment') 💳 Payment
                    @elseif($notification->type === 'cancellation') ✗ Cancellation
                    @elseif($notification->type === 'checkin') 🔓 Check-in
                    @elseif($notification->type === 'checkout') 🚪 Check-out
                    @else ℹ Info @endif
                </span>
            </div>
            <p class="notif-msg">{{ $notification->message }}</p>
            <div class="notif-meta">
                <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                @if($notification->order)
                    <a href="{{ route('tamu.orders.show', $notification->order) }}" class="notif-order-link">View Order Details →</a>
                @endif
            </div>
        </div>
        @if(!$notification->read_at)
        <div class="notif-action">
            <button onclick="markAsRead({{ $notification->id }})" class="notif-mark-btn">Mark as Read</button>
        </div>
        @endif
    </div>
    @endforeach
</div>
{{ $notifications->links() }}
@endif
@endsection

@push('scripts')
<script>
function markAsRead(id){
    fetch(`/tamu/notifications/${id}/read`,{method:'POST',headers:{'X-CSRF-Token':document.querySelector('meta[name="csrf-token"]').content,'Content-Type':'application/json'}})
    .then(r=>r.json()).then(d=>{if(d.success)location.reload();});
}
function markAllAsRead(){
    showConfirm('Mark All as Read?','All notifications will be marked as read',()=>{
        fetch('/tamu/notifications/read-all',{method:'POST',headers:{'X-CSRF-Token':document.querySelector('meta[name="csrf-token"]').content,'Content-Type':'application/json'}})
        .then(r=>r.json()).then(d=>{if(d.success){showSuccess('Success','All marked as read');setTimeout(()=>location.reload(),1500);}});
    });
}
</script>
@endpush
