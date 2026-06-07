@extends('resepsionis.layouts.app')

@section('title', 'Order Detail - #' . $order->order_code)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 md:py-8">
    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-xs md:text-sm text-slate-500 font-medium">
        <a href="{{ route('resepsionis.orders.index') }}" class="hover:text-indigo-600 transition">Order List</a>
        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
        <span class="text-slate-800 font-semibold">#{{ $order->order_code }}</span>
    </div>

    {{-- Alert Notifications --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Main Order Card --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden mb-8">
        {{-- Card Header --}}
        <div class="p-6 md:p-8 bg-slate-50/50 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Transaction Detail</span>
                <div class="flex items-center gap-3 mt-1">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">#{{ $order->order_code }}</h1>
                    @if($order->is_walkin)
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg text-[9px] font-bold">WALK-IN</span>
                    @endif
                </div>
                <p class="text-xs text-slate-400 font-medium mt-1">Created at: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('tamu.invoice.show', $order) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-2xl transition duration-200 font-bold text-xs shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Print Invoice
                </a>
            </div>
        </div>

        {{-- Stepper Visual Timeline --}}
        <div class="px-6 md:px-8 py-8 border-b border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-6">Stay Progress</h3>
            <div class="grid grid-cols-3 relative">
                {{-- Line connector --}}
                <div class="absolute left-[16.6%] right-[16.6%] top-4 h-1 bg-slate-100 z-0">
                    <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ $order->checked_out_at ? '100%' : ($order->checked_in_at ? '50%' : '0%') }}"></div>
                </div>

                {{-- Step 1 --}}
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-100">
                        ✓
                    </div>
                    <span class="text-xs font-bold text-slate-800 mt-2">Booked</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">{{ $order->created_at->format('d M H:i') }}</span>
                </div>

                {{-- Step 2 --}}
                <div class="flex flex-col items-center text-center relative z-10">
                    @if($order->checked_in_at)
                        <div class="w-9 h-9 rounded-full flex items-center justify-center bg-indigo-600 text-white font-bold text-xs shadow-md shadow-indigo-100">
                            ✓
                        </div>
                    @else
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 border-slate-200 bg-white text-slate-400 font-bold text-xs">
                            2
                        </div>
                    @endif
                    <span class="text-xs font-bold {{ $order->checked_in_at ? 'text-slate-800' : 'text-slate-400' }} mt-2">Check-In</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">
                        {{ $order->checked_in_at ? $order->checked_in_at->format('d M H:i') : $order->check_in->format('d M Y') }}
                    </span>
                </div>

                {{-- Step 3 --}}
                <div class="flex flex-col items-center text-center relative z-10">
                    @if($order->checked_out_at)
                        <div class="w-9 h-9 rounded-full flex items-center justify-center bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-100">
                            ✓
                        </div>
                    @else
                        <div class="w-9 h-9 rounded-full flex items-center justify-center border-2 border-slate-200 bg-white text-slate-400 font-bold text-xs">
                            3
                        </div>
                    @endif
                    <span class="text-xs font-bold {{ $order->checked_out_at ? 'text-slate-800' : 'text-slate-400' }} mt-2">Check-Out</span>
                    <span class="text-[9px] text-slate-400 mt-0.5">
                        {{ $order->checked_out_at ? $order->checked_out_at->format('d M H:i') : $order->check_out->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Guest details --}}
            <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100 space-y-4">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Guest Information
                </h3>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Full Name</p>
                        <p class="font-bold text-slate-900 mt-1 text-sm">{{ $order->guest_name ?? $order->user?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">WhatsApp Number</p>
                        <p class="font-bold text-slate-900 mt-1 text-sm">{{ $order->guest_phone ?? $order->user?->phone ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Account Email Address</p>
                        <p class="font-medium text-slate-800 mt-1">{{ $order->user?->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Reservation timeline --}}
            <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-100 space-y-4">
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Stay Duration
                </h3>
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Check-In</p>
                        <p class="font-bold text-slate-900 mt-1 text-sm">{{ $order->check_in->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-bold uppercase tracking-wider text-[9px]">Check-Out</p>
                        <p class="font-bold text-slate-900 mt-1 text-sm">{{ $order->check_out->format('d M Y') }}</p>
                    </div>
                    <div class="col-span-2 border-t border-slate-200/50 pt-2.5 flex justify-between items-center">
                        <p class="text-slate-500 font-bold">Total Nights</p>
                        <p class="font-black text-slate-900 text-sm">{{ $order->nights }} {{ $order->nights > 1 ? 'Nights' : 'Night' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pricing / Invoice details --}}
        <div class="p-6 md:p-8 border-t border-slate-100">
            <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Billing Details
            </h3>
            
            <div class="space-y-3">
                @if($order->items && $order->items->count() > 0)
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-slate-100/50 transition">
                            <div>
                                <p class="font-bold text-slate-900 text-sm">{{ $item->room->room_name ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $item->nights }} {{ $item->nights > 1 ? 'nights' : 'night' }} × Rp {{ number_format($item->price_per_night, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-black text-slate-900 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-slate-100 space-y-3 max-w-md ml-auto text-xs">
                @if($order->discount_amount > 0)
                    <div class="flex justify-between font-medium">
                        <span class="text-slate-500">Voucher Discount</span>
                        <span class="text-emerald-600 font-bold">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center text-sm font-bold pt-2 border-t border-slate-100/50">
                    <span class="text-slate-800 text-base">Total Bill</span>
                    <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                @if($order->payment_method)
                    <div class="flex justify-between text-[10px] text-slate-400 font-bold uppercase tracking-widest pt-2">
                        <span>Payment Method</span>
                        <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded font-mono">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Status summary indicators --}}
        <div class="p-6 md:p-8 bg-slate-50/50 border-t border-slate-100 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Order Status</p>
                <p class="mt-1.5 font-bold text-xs text-slate-800">{{ strtoupper($order->status) }}</p>
            </div>
            <div class="border-l border-slate-200/50">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Payment Status</p>
                <p class="mt-1.5 font-bold text-xs text-slate-800">{{ strtoupper($order->payment_status ?? 'PENDING') }}</p>
            </div>
            <div class="border-l border-slate-200/50 col-span-2 md:col-span-1">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Check-in Time</p>
                <p class="mt-1.5 font-bold text-xs text-slate-800">{{ $order->checked_in_at ? $order->checked_in_at->format('d/m Y H:i') : '-' }}</p>
            </div>
            <div class="border-l border-slate-200/50 col-span-2 md:col-span-1">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Check-out Time</p>
                <p class="mt-1.5 font-bold text-xs text-slate-800">{{ $order->checked_out_at ? $order->checked_out_at->format('d/m Y H:i') : '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Review (if any) --}}
    @if($order->review)
        <div class="bg-amber-50/40 border border-amber-100 p-6 md:p-8 rounded-[2rem] shadow-sm mb-8 space-y-4">
            <h3 class="text-base font-black text-amber-800 flex items-center gap-2">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Guest Review
            </h3>
            <div class="space-y-3">
                <div class="flex gap-1 text-amber-500">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-4 h-4 {{ $i <= $order->review->rating ? 'fill-current' : 'text-amber-200' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
                <p class="text-slate-700 italic text-sm">"{{ $order->review->review }}"</p>
                @if($order->review->admin_reply)
                    <div class="mt-4 p-4 bg-white rounded-2xl border border-amber-200/50">
                        <p class="text-[9px] font-bold text-amber-800 uppercase tracking-widest mb-1.5">Admin Response:</p>
                        <p class="text-sm text-slate-600 font-medium">{{ $order->review->admin_reply }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Cancellation Info --}}
    @if($order->status === 'cancelled' && $order->cancelled_reason)
        <div class="bg-rose-50 border border-rose-100 p-6 md:p-8 rounded-[2rem] shadow-sm mb-8 text-rose-800">
            <h3 class="text-base font-black mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Cancellation Information
            </h3>
            <p class="text-sm font-medium">Cancellation Reason: <span class="italic text-slate-700 font-normal">"{{ $order->cancelled_reason }}"</span></p>
        </div>
    @endif

    {{-- Footer Actions --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <a href="{{ route('resepsionis.orders.index') }}"
           class="inline-flex items-center gap-2 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl transition duration-200 font-bold text-sm">
            ← Back to List
        </a>

        <div class="flex gap-2.5">
            @if($order->status !== 'cancelled' && !$order->checked_in_at && $order->payment_status === 'paid')
                <form method="POST" action="{{ route('resepsionis.orders.checkin', $order) }}">
                    @csrf
                    <button type="submit" class="px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl hover:shadow-lg transition duration-200 font-bold text-sm">
                        Process Check-In
                    </button>
                </form>
            @endif

            @if($order->checked_in_at && !$order->checked_out_at)
                <form method="POST" action="{{ route('resepsionis.orders.checkout', $order) }}">
                    @csrf
                    <button type="submit" class="px-6 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-2xl hover:shadow-lg transition duration-200 font-bold text-sm">
                        Process Check-Out
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
