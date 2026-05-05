<?php

namespace App\Http\Controllers\Tamu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('tamu.booking.index');
        }

        $grandTotal = collect($cart)->sum('subtotal');

        return view('tamu.reservation.index', compact('cart', 'grandTotal'));
    }


    public function confirm(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string',
            'guest_phone' => 'required|string',
            'payment_method' => 'required',
        ]);

        // SIMPAN KE DATABASE (orders & order_items)
        // (tahap ini bisa kita lanjutkan nanti)

        session()->forget(['cart', 'booking_filter']);

        return redirect()->route('tamu.dashboard')
            ->with('success', 'Booking successful');
    }
    public function applyGuestInfo(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|min:3',
            'phone'  => 'required|string|min:8',
            'voucher'=> 'nullable|string'
        ]);

        session()->put('guest', [
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        $discount = 0;
        $code = null;

        if ($request->filled('voucher')) {
            $voucher = Voucher::where('code', $request->voucher)
                ->where('is_active', 1)
                ->whereDate('ends_at', '>=', now())
                ->first();

            if (!$voucher) {
                return back()->withErrors([
                    'voucher' => 'Voucher code is invalid or expired'
                ]);
            }

            $discount = $voucher->amount;
            $code = $voucher->code;
        }

        session()->put('voucher', [
            'code' => $code,
            'discount' => $discount
        ]);

        return back()->with('success', 'Guest information saved');
    }
}