<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Must be checked out
        if (!$order->checked_out_at) {
            return back()->with('error', 'You can only give a review after completing your stay.');
        }

        // Cannot review twice
        if ($order->review) {
            return back()->with('error', 'You have already submitted a review for this order.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
