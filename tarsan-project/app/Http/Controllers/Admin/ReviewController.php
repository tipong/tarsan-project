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

        $reviews = $query->paginate(10)->withQueryString();

        $averageRating = round(Review::avg('rating') ?? 5, 1);
        $totalReviews  = Review::count();

        return view('admin.reviews.index', compact(
            'reviews',
            'averageRating',
            'totalReviews'
        ));
    }
}
