<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'order'])
            ->whereHas('order', function ($q) {
                $q->whereNotNull('checked_out_at');
            })
            ->latest();

        /* =====================
         | SEARCH
         ===================== */
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $reviews = $query->paginate(10);

        $averageRating = round(Review::avg('rating') ?? 5, 1);
        $totalReviews  = Review::count();

        return view('admin.reviews.index', compact(
            'reviews',
            'averageRating',
            'totalReviews'
        ));
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:500',
        ]);

        // ❌ Cannot reply to reviews from incomplete orders
        if (! $review->order || ! $review->order->checked_out_at) {
            return back()->with('error', 'Review is not valid');
        }

        $review->update([
            'admin_reply' => $request->admin_reply,
        ]);

        return back()->with('success', 'Reply successfully sent');
    }
}
