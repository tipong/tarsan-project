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
            return back()->with('error', 'Anda hanya bisa memberikan ulasan setelah selesai menginap.');
        }

        // Cannot review twice
        if ($order->review) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
