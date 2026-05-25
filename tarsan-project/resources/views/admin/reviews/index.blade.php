@extends('admin.layouts.app')

@section('title', 'Reviews')

@section('content')

<h1 class="text-xl font-semibold mb-4">Reviews</h1>

{{-- SUMMARY --}}
<div class="flex items-center gap-4 mb-4">
    <div class="text-yellow-500 text-lg">
        ⭐ {{ number_format($averageRating, 1) }}
    </div>
    <div class="text-slate-600">
        {{ $totalReviews }} Reviews
    </div>
</div>

{{-- SEARCH --}}
<form method="GET" class="mb-4">
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Search guest..."
        class="border rounded-xl px-4 py-2 w-64">
</form>

{{-- LIST --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($reviews as $review)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
            <div class="flex items-center gap-4 mb-4">
                <img
                    src="{{ image_url($review->user?->photo) }}"
                    class="w-12 h-12 rounded-full object-cover ring-2 ring-slate-100">

                <div class="flex-1 min-w-0">
                    <p class="font-bold text-slate-900 truncate">{{ $review->user->name ?? 'Former Guest' }}</p>
                    <p class="text-xs text-slate-500">
                        {{ $review->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                <div class="flex items-center gap-1 text-yellow-500 bg-yellow-50 px-2 py-1 rounded-lg">
                    <span class="text-sm font-bold">{{ $review->rating }}</span>
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-slate-50 p-4 rounded-xl flex-1 mb-4 italic text-slate-700">
                "{{ $review->review }}"
            </div>

            {{-- ORDER INFO --}}
            @if($review->order)
                <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-xl mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-black text-indigo-900 uppercase tracking-wider">Related Order</h4>
                        <span class="text-[10px] font-bold text-indigo-600 bg-white px-2 py-1 rounded-lg">{{ $review->order->order_code }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-xs mb-3">
                        <div>
                            <p class="text-indigo-600 font-bold">Check-in Date</p>
                            <p class="text-slate-700 font-medium">{{ $review->order->check_in->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-indigo-600 font-bold">Check-out Date</p>
                            <p class="text-slate-700 font-medium">{{ $review->order->check_out->format('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- ROOMS BOOKED --}}
                    <div class="border-t border-indigo-200 pt-3">
                        <p class="text-[10px] font-black text-indigo-900 uppercase tracking-wider mb-2">Booked Rooms</p>
                        <div class="space-y-2">
                            @foreach($review->order->items as $item)
                                <div class="flex items-center justify-between bg-white p-2 rounded-lg">
                                    <span class="text-xs font-bold text-slate-700">{{ $item->room?->room_name ?? 'N/A' }}</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-slate-500">{{ $item->nights }} nights</span>
                                        <span class="text-xs font-bold text-indigo-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- TOTAL PRICE --}}
                    <div class="border-t border-indigo-200 pt-3 mt-3 flex justify-between items-center">
                        <span class="text-[10px] font-black text-indigo-900 uppercase tracking-wider">Total Payment</span>
                        <span class="text-sm font-black text-indigo-600">Rp {{ number_format($review->order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif

            <div class="border-t border-slate-50 pt-4">
                <form method="POST" action="{{ route('admin.reviews.reply', $review) }}">
                    @csrf
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Admin Reply</label>
                    <textarea
                        name="admin_reply"
                        rows="2"
                        class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-600 outline-none transition bg-white"
                        placeholder="Type reply for guest...">{{ $review->admin_reply }}</textarea>

                    <div class="flex justify-end mt-3">
                        <button class="bg-indigo-600 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                            Save Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
            <p class="text-slate-400 font-medium">No reviews found</p>
        </div>
    @endforelse
    </div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection
