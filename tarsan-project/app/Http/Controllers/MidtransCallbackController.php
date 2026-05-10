<?php

namespace App\Http\Controllers;

use App\Services\MidtransPaymentService;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request, MidtransPaymentService $midtransPayment)
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

        $order = $midtransPayment->findOrderByGatewayReference($request->order_id);

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $midtransPayment->syncOrderStatus($order, $request->all());

        return response()->json(['message' => 'OK']);
    }
}
