<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ScbWebhookController extends Controller
{
    public function handleCallback(Request $request)
    {
        $data = $request->all();
        Log::info('SCB Webhook:', $data);

        $ref1 = $data['billPaymentRef1'] ?? null;
        $amount = $data['amount'] ?? 0;

        if ($ref1) {
            $order = Order::where('order_number', $ref1)->first();

            if ($order && $order->status == 'pending' && $amount >= $order->total_price) {
                $order->update([
                    'status' => 'paid',
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => 'scb_qr'
                ]);
            }
        }

        return response()->json(['resCode' => '00', 'resDesc' => 'success']);
    }
}
