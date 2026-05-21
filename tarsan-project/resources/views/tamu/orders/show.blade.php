@extends('layouts.tamu-inner')
@section('title', 'Order Details – Tarsan Homestay')
@section('page-tag', 'Account')
@section('page-title', 'Order Details')
@section('page-sub', 'Booking code: ' . $order->order_code)

@push('styles')
<style>
.os-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px}
.os-box{background:#fff;border:1px solid rgba(0,0,0,.07);padding:32px}
.os-title{font-family:'Playfair Display',serif;font-size:20px;font-weight:400;color:#1a1a1a;margin-bottom:20px}
.os-row{margin-bottom:14px}
.os-row:last-child{margin-bottom:0}
.os-label{font-size:10px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;margin-bottom:4px;display:block}
.os-val{font-size:14px;color:#1a1a1a}
.os-item{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(0,0,0,.06)}
.os-item:last-child{border-bottom:none}
.oi-name{font-size:14px;font-weight:500;color:#1a1a1a}
.oi-price{font-size:14px;color:#1a1a1a;font-weight:600}
.os-total{display:flex;justify-content:space-between;padding-top:16px;border-top:1px solid rgba(0,0,0,.06);margin-top:16px;font-family:'Playfair Display',serif;font-size:22px;font-weight:400}
.os-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:32px}
.os-btn{padding:12px 24px;font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;transition:all .3s;cursor:pointer;font-family:'Inter',sans-serif;border:none}
.ob-back{border:1px solid #1a1a1a;color:#1a1a1a;background:transparent}
.ob-back:hover{background:#1a1a1a;color:#fff}
.ob-pay{border:1px solid #059669;background:#059669;color:#fff}
.ob-pay:hover{background:#047857}
.ob-invoice{border:1px solid #7c3aed;background:#7c3aed;color:#fff}
.ob-invoice:hover{background:#6d28d9}
.ob-cancel{border:1px solid #dc2626;color:#dc2626;background:transparent}
.ob-cancel:hover{background:#dc2626;color:#fff}
.ob-review{border:1px solid #d97706;background:#d97706;color:#fff}
.ob-review:hover{background:#b45309}
.os-cancel-note{background:#fff5f5;border-left:3px solid #dc2626;padding:20px;margin-top:24px}
.os-cancel-note p{margin-bottom:8px;font-size:13px;color:#991b1b}
.os-cancel-note p:last-child{margin-bottom:0}

/* MODAL */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:300;align-items:center;justify-content:center;padding:24px}
.modal-overlay.open{display:flex}
.modal-box{background:#fff;padding:40px;max-width:500px;width:100%;position:relative}
.modal-title{font-family:'Playfair Display',serif;font-size:24px;font-weight:400;color:#1a1a1a;margin-bottom:8px}
.modal-sub{font-size:13px;font-weight:300;color:#888;margin-bottom:28px}
.modal-label{font-size:11px;font-weight:600;letter-spacing:.15em;text-transform:uppercase;color:#8a7a65;display:block;margin-bottom:12px}
.modal-textarea{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:12px 14px;font-size:13px;font-family:'Inter',sans-serif;outline:none;resize:vertical;min-height:80px;margin-bottom:0}
.modal-actions{display:flex;gap:8px}
.star-select select{width:100%;background:#f8f5ef;border:1px solid rgba(0,0,0,.1);padding:10px 14px;font-size:13px;font-family:'Inter',sans-serif;outline:none;margin-bottom:20px}
/* Radio button cancel reason */
.cancel-reasons{display:flex;flex-direction:column;gap:8px;margin-bottom:20px}
.cancel-reason-item{display:flex;align-items:center;gap:10px;padding:10px 14px;border:1px solid rgba(0,0,0,.1);background:#f8f5ef;cursor:pointer;transition:all .2s}
.cancel-reason-item:hover{border-color:#dc2626;background:#fff5f5}
.cancel-reason-item input[type=radio]{accent-color:#dc2626;width:16px;height:16px;cursor:pointer;flex-shrink:0}
.cancel-reason-item label{font-size:13px;color:#1a1a1a;cursor:pointer;flex:1}
.cancel-reason-item.selected{border-color:#dc2626;background:#fff5f5}
.cancel-other-wrap{margin-bottom:20px;display:none}
.cancel-other-wrap.show{display:block}
@media(max-width:900px){.os-grid{grid-template-columns:1fr}}
</style>
@endpush

@section('inner-content')
<div class="breadcrumb" style="margin-bottom:24px;font-size:12px">
    <a href="{{ route('tamu.orders') }}" style="color:#6b5c47;text-decoration:none">← Back to Orders</a>
</div>

<div class="os-grid">
    {{-- OVERVIEW --}}
    <div class="os-box">
        <h2 class="os-title">Order Overview</h2>
        <div class="os-row">
            <span class="os-label">Order Code</span>
            <span class="os-val" style="font-family:'Playfair Display',serif;font-size:18px">{{ $order->order_code }}</span>
        </div>
        <div class="os-row">
            <span class="os-label">Created At</span>
            <span class="os-val">{{ $order->created_at->format('d M Y H:i') }}</span>
        </div>
        <div class="os-row">
            <span class="os-label">Order Status</span>
            @if($order->status === 'completed')
                <span class="badge badge-paid">Completed</span>
            @elseif($order->status === 'cancelled')
                <span class="badge badge-cancelled">Cancelled</span>
            @elseif($order->status === 'pending')
                <span class="badge badge-pending">Waiting Payment</span>
            @elseif($order->status === 'confirmed')
                <span class="badge badge-confirmed">Confirmed</span>
            @else
                <span class="badge" style="background:#f1f5f9;color:#475569">{{ ucfirst($order->status) }}</span>
            @endif
        </div>
        <div class="os-row">
            <span class="os-label">Payment Status</span>
            @if($order->payment_status === 'paid')
                <span class="badge badge-paid">Paid</span>
            @elseif($order->payment_status === 'refunded')
                <span class="badge" style="background:#ffedd5;color:#c2410c">Refunded</span>
            @elseif($order->payment_status === 'expired')
                <span class="badge" style="background:#ffedd5;color:#c2410c">Expired</span>
            @elseif($order->payment_status === 'failed')
                <span class="badge badge-cancelled">Failed</span>
            @else
                <span class="badge badge-pending">Waiting Payment</span>
            @endif
        </div>
    </div>

    {{-- GUEST INFO --}}
    <div class="os-box">
        <h2 class="os-title">Guest Information</h2>
        <div class="os-row">
            <span class="os-label">Guest Name</span>
            <span class="os-val">{{ $order->guest_display_name }}</span>
        </div>
        @if($order->guest_phone)
        <div class="os-row">
            <span class="os-label">Phone Number</span>
            <span class="os-val">{{ $order->guest_phone }}</span>
        </div>
        @endif
        @if($order->user)
        <div class="os-row">
            <span class="os-label">Email</span>
            <span class="os-val">{{ $order->user->email }}</span>
        </div>
        @endif
    </div>
</div>

<div class="os-box" style="margin-bottom:24px">
    <h2 class="os-title">Stay & Pricing Details</h2>
    @if($order->items->count() > 0)
        @foreach($order->items as $item)
            <div class="os-item">
                <span class="oi-name">{{ $item->room->room_name ?? 'Room' }} ({{ $item->nights }} nights)</span>
                <span class="oi-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
            </div>
        @endforeach
    @endif

    <div class="os-total">
        <span>Total</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>

    @if($order->payment_method)
        <div style="margin-top:16px;font-size:12px;color:#666">
            Payment Method: {{ str_replace('_', ' ', strtoupper($order->payment_method)) }}
        </div>
    @endif
</div>

@if($order->status === 'cancelled' && $order->cancelled_reason)
<div class="os-cancel-note">
    <p><strong>Cancelled on:</strong> {{ $order->cancelled_at ? $order->cancelled_at->format('d M Y H:i') : 'N/A' }}</p>
    <p><strong>Reason:</strong> {{ $order->cancelled_reason }}</p>
</div>
@endif

<div class="os-actions">
    @if($order->payment_status === 'paid')
        <a href="{{ route('tamu.invoice.show', $order->id) }}" class="os-btn ob-invoice">View Invoice</a>
    @endif

    @if($order->status === 'pending' && $order->payment_status !== 'paid')
        <a href="{{ route('tamu.payment.index', $order->id) }}" class="os-btn ob-pay">Continue Payment</a>
    @endif

    @if(in_array($order->status, ['pending', 'confirmed']))
        <button type="button" onclick="openCancelModal()" class="os-btn ob-cancel">Cancel Order</button>
    @endif

    @if($order->checked_out_at && !$order->review)
        <button type="button" onclick="openReviewModal()" class="os-btn ob-review">Leave Review</button>
    @elseif($order->review)
        <span class="os-btn" style="border:1px solid rgba(0,0,0,.08);color:#6b5c47;cursor:default">⭐ {{ $order->review->rating }} / 5 (Reviewed)</span>
    @endif
</div>

{{-- CANCEL MODAL --}}
<div class="modal-overlay" id="cancelModal">
    <div class="modal-box">
        <h3 class="modal-title">Cancel Order</h3>
        <p class="modal-sub">Please select a reason for cancelling this order.</p>
        <form id="cancelForm" method="POST">
            @csrf
            <span class="modal-label">Cancellation Reason</span>
            <div class="cancel-reasons" id="cancelReasonList">
                <div class="cancel-reason-item" onclick="selectReason(this, 'change_of_plans')">  
                    <input type="radio" name="reason_option" value="change_of_plans" id="r1">
                    <label for="r1">Change of plans</label>
                </div>
                <div class="cancel-reason-item" onclick="selectReason(this, 'found_better_option')">  
                    <input type="radio" name="reason_option" value="found_better_option" id="r2">
                    <label for="r2">Found a better option</label>
                </div>
                <div class="cancel-reason-item" onclick="selectReason(this, 'emergency')">  
                    <input type="radio" name="reason_option" value="emergency" id="r3">
                    <label for="r3">Emergency / Unexpected situation</label>
                </div>
                <div class="cancel-reason-item" onclick="selectReason(this, 'incorrect_booking')">  
                    <input type="radio" name="reason_option" value="incorrect_booking" id="r4">
                    <label for="r4">Incorrect booking details</label>
                </div>
                <div class="cancel-reason-item" onclick="selectReason(this, 'other')">  
                    <input type="radio" name="reason_option" value="other" id="r5">
                    <label for="r5">Other reason</label>
                </div>
            </div>
            <div class="cancel-other-wrap" id="otherReasonWrap">
                <span class="modal-label" style="margin-bottom:8px">Please specify</span>
                <textarea id="otherReasonText" class="modal-textarea" placeholder="Describe your reason here..." style="margin-bottom:20px"></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="closeCancelModal()" class="btn-dark" style="flex:1">Back</button>
                <button type="submit" class="os-btn ob-cancel" style="flex:1;padding:11px 20px">Confirm Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- REVIEW MODAL --}}
<div class="modal-overlay" id="reviewModal">
    <div class="modal-box">
        <h3 class="modal-title">Leave a Review</h3>
        <p class="modal-sub">How was your stay with us?</p>
        <form id="reviewForm" method="POST" action="/tamu/orders/{{ $order->id }}/review">
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
            <span class="modal-label">Review</span>
            <textarea name="review" class="modal-textarea" placeholder="Tell us about your experience..." required></textarea>
            <div class="modal-actions">
                <button type="button" onclick="closeReviewModal()" class="btn-dark" style="flex:1">Cancel</button>
                <button type="submit" class="os-btn ob-review" style="flex:1;padding:11px 20px">Submit Review</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const currentOrderId = {{ $order->id }};

const reasonLabels = {
    'change_of_plans': 'Change of plans',
    'found_better_option': 'Found a better option',
    'emergency': 'Emergency / Unexpected situation',
    'incorrect_booking': 'Incorrect booking details',
    'other': null // will use textarea value
};

function selectReason(el, value) {
    // Deselect all
    document.querySelectorAll('.cancel-reason-item').forEach(item => item.classList.remove('selected'));
    // Select clicked
    el.classList.add('selected');
    // Check the radio
    el.querySelector('input[type=radio]').checked = true;
    // Show/hide textarea for "other"
    const otherWrap = document.getElementById('otherReasonWrap');
    if (value === 'other') {
        otherWrap.classList.add('show');
    } else {
        otherWrap.classList.remove('show');
        document.getElementById('otherReasonText').value = '';
    }
}

function openCancelModal(){
    document.getElementById('cancelModal').classList.add('open');
}
function closeCancelModal(){
    document.getElementById('cancelModal').classList.remove('open');
    // Reset all
    document.querySelectorAll('.cancel-reason-item').forEach(item => item.classList.remove('selected'));
    document.querySelectorAll('input[name=reason_option]').forEach(r => r.checked = false);
    document.getElementById('otherReasonWrap').classList.remove('show');
    document.getElementById('otherReasonText').value = '';
}

document.getElementById('cancelForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const selectedRadio = document.querySelector('input[name=reason_option]:checked');
    if (!selectedRadio) {
        alert('Please select a cancellation reason.');
        return;
    }
    let reason;
    if (selectedRadio.value === 'other') {
        reason = document.getElementById('otherReasonText').value.trim();
        if (!reason) {
            alert('Please describe your reason.');
            return;
        }
    } else {
        reason = reasonLabels[selectedRadio.value];
    }

    fetch(`/tamu/orders/${currentOrderId}/cancel`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ reason: reason })
    }).then(r => r.json()).then(d => {
        closeCancelModal();
        if (d.success) { alert(d.message); location.reload(); }
        else { alert(d.message); }
    }).catch(() => { alert('An error occurred. Please try again.'); });
});

function openReviewModal(){ document.getElementById('reviewModal').classList.add('open'); }
function closeReviewModal(){ document.getElementById('reviewModal').classList.remove('open'); document.getElementById('reviewForm').reset(); }
</script>
@include('tamu.orders.partials.continue-payment-script')
@endpush
