@extends('admin.layouts.app')

@section('title', 'Order Details - ' . $order->order_code)

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm text-slate-600">
        <a href="{{ route('admin.orders.index') }}" class="hover:text-indigo-600">Order List</a>
        <span>›</span>
        <span class="text-slate-800">{{ $order->order_code }}</span>
    </div>

    {{-- Order Header --}}
    <div class="bg-white p-6 rounded-2xl shadow-md mb-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm text-slate-600 mb-1">Order Code</p>
                <h1 class="text-2xl font-bold text-slate-800">{{ $order->order_code ?? 'N/A' }}</h1>
                <p class="text-xs text-slate-500 mt-2">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tamu.invoice.show', $order) }}"
                   target="_blank"
                   class="px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition duration-200 font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    View Invoice
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-slate-100">
            <div>
                <p class="text-sm text-slate-600 mb-1">Order Status</p>
                <div>
                    @if($order->status === 'completed')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">✓ Completed</span>
                    @elseif($order->status === 'cancelled')
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">✗ Cancelled</span>
                    @elseif($order->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">⏳ Waiting for Payment</span>
                    @elseif($order->status === 'confirmed')
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">📋 Confirmed</span>
                    @else
                        <span class="px-3 py-1 bg-gray-50 text-slate-700 rounded-full text-sm font-semibold">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
            </div>

            <div>
                <p class="text-sm text-slate-600 mb-1">Payment Status</p>
                <div>
                    @if($order->payment_status === 'paid')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">✓ Paid</span>
                    @elseif($order->payment_status === 'refunded')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">↩️ Refunded</span>
                    @elseif($order->payment_status === 'expired')
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">⏰ Expired</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">✗ Failed</span>
                    @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">⏳ Waiting for Payment</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Guest & Room Info --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Guest Information --}}
        <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Guest Information
            </h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Guest Name</p>
                    <p class="font-semibold text-slate-800 text-lg">{{ $order->guest_name ?? $order->user?->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Phone Number</p>
                    <p class="font-medium text-slate-800">{{ $order->guest_phone ?? $order->user?->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Account Email</p>
                    <p class="font-medium text-slate-800">{{ $order->user?->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Room Information --}}
        <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Stay Details
            </h3>
            <div class="space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Check-in</p>
                        <p class="font-semibold text-slate-800">{{ $order->check_in ? $order->check_in->format('d M Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Check-out</p>
                        <p class="font-semibold text-slate-800">{{ $order->check_out ? $order->check_out->format('d M Y') : 'N/A' }}</p>
                    </div>
                </div>
                <div class="pt-3 border-t border-slate-50">
                    <p class="text-sm text-slate-500">Stay Duration</p>
                    <p class="font-semibold text-slate-800">{{ $order->nights ?? 1 }} night</p>
                </div>
                @if($order->checked_in_at)
                <div>
                    <p class="text-sm text-slate-500 text-green-600">Check-in Detected</p>
                    <p class="text-xs text-slate-500">{{ $order->checked_in_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
                @if($order->checked_out_at)
                <div>
                    <p class="text-sm text-slate-500 text-blue-600">Check-out Detected</p>
                    <p class="text-xs text-slate-500">{{ $order->checked_out_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Pricing Details --}}
    <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-100 mb-6">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16V15m0 1v1m4-12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Order Details
        </h3>

        @if($order->items && $order->items->count() > 0)
            <div class="space-y-4 mb-6">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <div>
                            <p class="font-bold text-slate-800">{{ $item->room->room_name ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500">{{ $item->nights }} night × Rp {{ number_format($item->price_per_night, 0, ',', '.') }}</p>
                        </div>
                        <span class="font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="border-t border-slate-100 pt-4">
            @if($order->discount_amount > 0)
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-500">Discount</span>
                <span class="text-green-600 font-medium">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-slate-800">Final Total</span>
                <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            @if($order->payment_method)
                <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                    <span class="px-2 py-1 bg-slate-100 rounded-md">Metode: {{ ucfirst($order->payment_method) }}</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Review (if any) --}}
    @if($order->review)
    <div class="bg-yellow-50 border border-yellow-100 p-6 rounded-2xl shadow-md mb-6">
        <h3 class="text-lg font-bold text-yellow-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            Guest Review
        </h3>
        <div class="space-y-2">
            <div class="flex gap-1 text-yellow-500">
                @for($i=1; $i<=5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $order->review->rating ? 'fill-current' : 'text-yellow-200' }}" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                @endfor
            </div>
            <p class="text-slate-700 italic">"{{ $order->review->review }}"</p>
            @if($order->review->admin_reply)
                <div class="mt-4 p-3 bg-white rounded-xl border border-yellow-200">
                    <p class="text-xs font-bold text-yellow-800 uppercase tracking-wider mb-1">Admin Reply:</p>
                    <p class="text-sm text-slate-600">{{ $order->review->admin_reply }}</p>
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Cancellation Reason (if cancelled) --}}
    @if($order->status === 'cancelled' && $order->cancelled_reason)
        <div class="bg-red-50 border border-red-200 p-6 rounded-2xl shadow-md mb-6 text-red-700">
            <h3 class="text-lg font-bold mb-2">Cancellation Information</h3>
            <p class="text-sm"><strong>Reason:</strong> {{ $order->cancelled_reason }}</p>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex flex-wrap gap-3 mt-8">
        <a href="{{ route('admin.orders.index') }}"
           class="px-6 py-2.5 border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 transition font-medium">
            ← Back
        </a>

        @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
            <form method="POST" action="{{ route('admin.orders.checkin', $order) }}">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-medium shadow-md">
                    Check In Guest
                </button>
            </form>
        @endif

        @if($order->checked_in_at && !$order->checked_out_at)
            <form method="POST" action="{{ route('admin.orders.checkout', $order) }}">
                @csrf
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-medium shadow-md">
                    Check Out Guest
                </button>
            </form>
        @endif
    </div>
</div>
@endsection
