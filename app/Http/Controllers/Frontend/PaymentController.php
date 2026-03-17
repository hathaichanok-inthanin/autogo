<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;

class PaymentController extends Controller
{
    public function uploadSlip(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'slip_image' => 'required|image|max:5120', 
            'transfer_amount' => 'required|numeric'
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($request->hasFile('slip_image')) {
            $fileName = 'slip_' . $order->order_number . '_' . time() . '.' . $request->slip_image->extension();
            $request->slip_image->storeAs('public/slips', $fileName); 
            
            $order->slip_image = $fileName;
        }

        $order->transfer_date = $request->transfer_date . ' ' . $request->transfer_time;
        $order->transfer_amount = $request->transfer_amount;
        
        $order->payment_status = 'waiting_verify';
        $order->save();

        return redirect()->route('checkout.success', ['id' => $order->id])->with('success', 'ได้รับหลักฐานการโอนเงินแล้ว ทางเราจะรีบตรวจสอบให้เร็วที่สุดครับ');
    }
}
