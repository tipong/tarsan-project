<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');

        $signatureKey = hash(
            'sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            config('midtrans.server_key')
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_code', $request->order_id)->first();
        if (!$order) return response()->json(['message' => 'Order not found']);

        if ($request->transaction_status === 'settlement') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'invoice_number' => 'INV-' . date('Ymd') . '-' . rand(1000,9999)
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}