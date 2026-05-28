@extends('layouts.tamu-inner')
@section('title', 'My Order – Tarsan Homestay')
@section('page-tag', 'Account')
@section('page-title', 'My Order')
@section('page-sub', 'Manage all your reservations and bookings')

@push('styles')
<style>
.order-card{background:#fff;border:1px solid rgba(0,0,0,.07);margin-bottom:2px;transition:box-shadow .3s}
.order-card:hover{box-shadow:0 4px 24px rgba(0,0,0,.08)}
.order-inner{padding:28px 32px}
.order-grid{display:grid;grid-template-columns:1.2fr 1fr 1fr 1fr 1.2fr;gap:24px;margin-bottom:24px}
.order-field-label{font-size:10px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:#8a7a65;margin-bottom:6px}
.order-code{font-family:'Playfair Display',serif;font-size:20px;font-weight:500;color:#1a1a1a}
.order-date{font-size:12px;color:#888;margin-top:4px}
.order-dates{font-family:'Playfair Display',serif;font-size:18px;font-weight:400;color:#1a1a1a}
.order-nights{font-size:12px;color:#888;margin-top:4px}
.order-total{font-family:'Playfair Display',serif;font-size:22px;font-weight:400;color:#1a1a1a}
.order-actions{display:flex;flex-wrap:wrap;gap:8px;padding-top:20px;border-top:1px solid rgba(0,0,0,.06)}
.oa{padding:9px 20px;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:all .3s;cursor:pointer;font-family:'Inter',sans-serif;border:none}
.oa-detail{border:1px solid #1a1a1a;color:#1a1a1a;background:transparent}
.oa-detail:hover{background:#1a1a1a;color:#fff}
.oa-pay{border:1px solid #059669;background:#059669;color:#fff}
.oa-pay:hover{background:#047857}
.oa-invoice{border:1px solid #7c3aed;background:#7c3aed;color:#fff}
.oa-invoice:hover{background:#6d28d9}
.oa-pdf{border:1px solid #059669;background:#059669;color:#fff}
.oa-pdf:hover{background:#047857}
.oa-cancel{border:1px solid #dc2626;color:#dc2626;background:transparent}
.oa-cancel:hover{background:#dc2626;color:#fff}
.oa-review{border:1px solid #d97706;background:#d97706;color:#fff}
.oa-review:hover{background:#b45309}
.cancel-note{margin-top:16px;padding:14px 20px;background:#fff5f5;border-left:3px solid #dc2626;font-size:13px;color:#991b1b}
/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:300;align-items:center;justify-content:center;padding:24px}
.modal-overlay.open{display:flex}
.modal-box{background:#fff;padding:40px;max-width:480px;width:100%;position:relative}
.modal-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:8px}
.modal-sub{font-size:13px;font-weight:300;color:#888;margin-bottom:28px}
.modal-label{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;display:block;margin-bottom:16px}
.modal-radio{display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid rgba(0,0,0,.06);cursor:pointer}
.modal-radio input{accent-color:#6b5c47}
.modal-radio span{font-size:13px;color:#444}
.modal-actions{display:flex;gap:8px;margin-top:24px}
.star-select{display:flex;gap:8px;margin-bottom:16px}
.star-select select{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:10px 14px;font-size:13px;font-family:'Inter',sans-serif;outline:none}
.review-textarea{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:12px 14px;font-size:13px;font-family:'Inter',sans-serif;outline:none;resize:vertical;min-height:100px;margin-top:4px}
@media(max-width:900px){
  .order-grid{grid-template-columns:1fr 1fr;gap:16px}
  .order-inner{padding:24px 20px}
}
@media(max-width:600px){
  .order-grid{grid-template-columns:1fr}
  .order-inner{padding:20px 16px}
  .order-actions{flex-direction:column}
  .oa{width:100%;text-align:center;display:block}
}
</style>
@endpush

@section('inner-content')
@if(session('success'))
    <div class="flash-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash-error">{{ session('error') }}</div>
@endif

@if($orders->isEmpty())
<div class="empty">
    <div class="empty-icon">📋</div>
    <h3 class="empty-title">No Orders Yet</h3>
    <p class="empty-sub">You haven't made any reservations. Start exploring our rooms!</p>
    <a href="{{ route('kamar.index') }}" class="btn-fill">Explore Rooms</a>
</div>
@else
<div>
    @foreach($orders as $order)
    <div class="order-card">
        <div class="order-inner">
            <div class="order-grid">
                <div>
                    <div class="order-field-label">Order Code</div>
                    <div class="order-code">{{ $order->order_code ?? 'N/A' }}</div>
                    <div class="order-date">{{ $order->created_at->format('d M Y · H:i') }}</div>
                </div>
                <div>
                    <div class="order-field-label">Dates</div>
                    @if($order->check_in_date && $order->check_out_date)
                        <div class="order-dates">{{ $order->check_in_date->format('d M') }} – {{ $order->check_out_date->format('d M Y') }}</div>
                        <div class="order-nights">{{ $order->nights ?? 1 }} nights</div>
                    @else
                        <div class="order-dates">N/A</div>
                    @endif
                </div>
                <div>
                    <div class="order-field-label">Order Status</div>
                    @if($order->status === 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($order->status === 'confirmed')
                        <span class="badge badge-confirmed">Confirmed</span>
                    @elseif($order->status === 'cancelled')
                        <span class="badge badge-cancelled">Cancelled</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569">{{ $order->status }}</span>
                    @endif
                </div>
                <div>
                    <div class="order-field-label">Payment</div>
                    @if($order->payment_status === 'paid')
                        <span class="badge badge-paid">Paid</span>
                    @elseif($order->payment_status === 'pending')
                        <span class="badge badge-pending">Pending</span>
                    @else
                        <span class="badge" style="background:#f1f5f9;color:#475569">{{ $order->payment_status }}</span>
                    @endif
                </div>
                <div>
                    <div class="order-field-label">Total</div>
                    <div class="order-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="order-actions">
                <a href="{{ route('tamu.orders.show', $order) }}" class="oa oa-detail">View Details</a>
                @if($order->status === 'pending' && $order->payment_status !== 'paid')
                    <a href="{{ route('tamu.payment.index', $order->id) }}" class="oa oa-pay">Continue Payment</a>
                @endif
                @if($order->payment_status === 'paid')
                    <a href="{{ route('tamu.invoice.show', $order) }}" class="oa oa-invoice">View Invoice</a>
                    <a href="{{ route('tamu.invoice.download', $order) }}" class="oa oa-pdf">Download PDF</a>
                @endif
                @if(in_array($order->status, ['pending', 'confirmed']) && $order->payment_status !== 'paid')
                    <button type="button" onclick="cancelOrder({{ $order->id }})" class="oa oa-cancel">Cancel Order</button>
                @endif
                @if($order->checked_out_at && !$order->review)
                    <button type="button" onclick="openReviewModal({{ $order->id }})" class="oa oa-review">Leave Review</button>
                @elseif($order->review)
                    <span class="oa" style="border:1px solid rgba(0,0,0,.08);color:#6b5c47;cursor:default">⭐ {{ $order->review->rating }} / 5</span>
                @endif
            </div>

            @if($order->status === 'cancelled' && $order->cancelled_reason)
                <div class="cancel-note">
                    <strong>Cancellation Reason:</strong> {{ $order->cancelled_reason }}
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
{{ $orders->links() }}
@endif

{{-- CANCEL MODAL --}}
<div class="modal-overlay" id="cancelModal">
    <div class="modal-box">
        <h3 class="modal-title">Cancel Order</h3>
        <p class="modal-sub">Please select a cancellation reason</p>
        <form id="cancelForm" method="POST">
            @csrf
            <span class="modal-label">Reason</span>
            @foreach(['Change of plans', 'Found better accommodation', 'Schedule conflict', 'Financial reasons', 'Other reasons'] as $reason)
                <label class="modal-radio">
                    <input type="radio" name="reason" value="{{ $reason }}">
                    <span>{{ $reason }}</span>
                </label>
            @endforeach
            <div class="modal-actions">
                <button type="button" onclick="document.getElementById('cancelModal').classList.remove('open')" class="btn-dark" style="flex:1">Back</button>
                <button type="submit" class="oa oa-cancel" style="flex:1;padding:11px 20px">Confirm Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- REVIEW MODAL --}}
<div class="modal-overlay" id="reviewModal">
    <div class="modal-box">
        <h3 class="modal-title">Leave a Review</h3>
        <p class="modal-sub">How was your stay experience?</p>
        <form id="reviewForm" method="POST">
            @csrf
            <span class="modal-label">Rating</span>
            <div class="star-select">
                <select name="rating" required>
                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                    <option value="4">⭐⭐⭐⭐ Good</option>
                    <option value="3">⭐⭐⭐ Fair</option>
                    <option value="2">⭐⭐ Poor</option>
                    <option value="1">⭐ Very Poor</option>
                </select>
            </div>
            <span class="modal-label">Review (optional)</span>
            <textarea name="review" class="review-textarea" placeholder="Tell us about your experience..."></textarea>
            <div class="modal-actions" style="margin-top:20px">
                <button type="button" onclick="document.getElementById('reviewModal').classList.remove('open')" class="btn-dark" style="flex:1">Cancel</button>
                <button type="submit" class="oa oa-review" style="flex:1;padding:11px 20px">Submit Review</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelOrder(id){
    document.getElementById('cancelForm').action=`/tamu/orders/${id}/cancel`;
    document.getElementById('cancelModal').classList.add('open');
}
function openReviewModal(id){
    document.getElementById('reviewForm').action=`/tamu/orders/${id}/review`;
    document.getElementById('reviewModal').classList.add('open');
}
</script>
@include('tamu.orders.partials.continue-payment-script')
@endpush
