@extends('admin.layouts.app')

@section('title', 'Reviews')

@section('content')

<h1 class="text-xl font-semibold mb-4">Reviews</h1>

{{-- SUMMARY --}}
<div class="flex items-center gap-4 mb-4">
    <div class="text-yellow-500 text-lg">
        ⭐ {{ number_format($averageRating, 1) }}
    </div>
    <div class="text-gray-600">
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
        class="border rounded px-4 py-2 w-64">
</form>

{{-- LIST --}}
<div class="space-y-4">
@forelse($reviews as $review)
    <div class="bg-white p-5 rounded shadow">

        <div class="flex items-center gap-3">
            <img
                src="{{ $review->user->photo
                    ? asset('storage/'.$review->user->photo)
                    : asset('images/default-avatar.png') }}"
                class="w-10 h-10 rounded-full object-cover">

            <div>
                <p class="font-semibold">{{ $review->user->name }}</p>
                <p class="text-xs text-gray-500">
                    {{ $review->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        {{-- RATING --}}
        <div class="text-yellow-500 mt-2">
            {{ str_repeat('⭐', $review->rating) }}
        </div>

        {{-- REVIEW --}}
        <p class="mt-2">{{ $review->review }}</p>

        {{-- ADMIN REPLY --}}
        <form method="POST"
              action="{{ route('admin.reviews.reply', $review) }}"
              class="mt-3">
            @csrf
            <textarea
                name="admin_reply"
                rows="2"
                class="w-full border rounded p-2"
                placeholder="Admin reply...">{{ $review->admin_reply }}</textarea>

            <button class="mt-2 bg-blue-600 text-white px-4 py-1 rounded">
                Reply
            </button>
        </form>

    </div>
@empty
    <p class="text-gray-500">No reviews found</p>
@endforelse
</div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection
