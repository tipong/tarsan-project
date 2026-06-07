@extends('admin.layouts.app')

@section('title', 'Reviews')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Guest Reviews</h1>
        <p class="text-slate-500 mt-1">Monitor and respond to guest feedback</p>
    </div>
    {{-- Rating Summary --}}
    <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-1 text-yellow-500">
            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            <span class="text-xl font-black text-slate-900">{{ number_format($averageRating, 1) }}</span>
        </div>
        <div class="border-l border-slate-200 pl-3">
            <p class="text-sm font-bold text-slate-700">{{ $totalReviews }} Reviews</p>
            <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Total</p>
        </div>
    </div>
</div>

{{-- SEARCH --}}
<div class="bg-white p-4 md:p-6 rounded-3xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-end">
        <div class="flex-1">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Search Guest</label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search by guest name..."
                class="w-full bg-slate-50 border-none rounded-2xl px-4 py-3 focus:ring-2 focus:ring-indigo-600 text-sm outline-none transition-all">
        </div>
        <div class="flex gap-2">
            <button class="flex-1 sm:flex-none bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition font-bold text-sm">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.reviews.index') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-2xl hover:bg-slate-200 transition font-bold text-sm">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- LIST --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 md:gap-6">
@forelse($reviews as $review)
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-md transition-shadow duration-200">
        <div>
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                    <img
                        src="{{ image_url($review->user?->photo) }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-100 shadow-sm shrink-0">
                    <div>
                        <p class="font-bold text-slate-800 text-sm truncate max-w-[150px] sm:max-w-xs">{{ $review->guest_name ?? $review->user?->name ?? 'Former Guest' }}</p>
                        <p class="text-[10px] text-slate-400 font-semibold mt-0.5">
                            {{ $review->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>
                
                {{-- Stars --}}
                <div class="flex items-center gap-0.5 text-amber-400 shrink-0 bg-amber-50/50 px-2 py-1 rounded-xl border border-amber-100/50">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
            </div>

            <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100/80 italic text-slate-700 text-sm leading-relaxed mb-4">
                "{{ $review->review ?? 'Tamu tidak menulis komentar detail.' }}"
            </div>
        </div>

        {{-- RELATED ORDER MINIMALIST INFO --}}
        @if($review->order)
            <div class="pt-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center gap-1.5 text-slate-500">
                    <span class="inline-flex items-center px-2 py-0.5 bg-slate-100 text-slate-700 font-bold font-mono text-[10px] rounded-lg border border-slate-200">#{{ $review->order->order_code }}</span>
                    <span class="text-slate-300">•</span>
                    <span class="font-semibold text-slate-650 truncate max-w-[200px]" title="@foreach($review->order->items as $item){{ $item->room?->room_name }}@if(!$loop->last), @endif @endforeach">
                        @foreach($review->order->items as $item)
                            {{ $item->room?->room_name }}@if(!$loop->last), @endif
                        @endforeach
                    </span>
                </div>
                <span class="font-bold text-indigo-600 shrink-0">Rp {{ number_format($review->order->total_price, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>
@empty
    <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-dashed border-slate-200">
        <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <p class="text-slate-400 font-medium">No reviews found</p>
    </div>
@endforelse
</div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection
