<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

use App\Services\ScbPaymentService;

use App\Models\Shop;
use App\Models\Order;
use App\Models\OrderDetail;

class CheckoutController extends Controller
{
    public function index(){
        $cart = session()->get('cart');

        if(!$cart) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        $branches = Shop::where('is_active', true)->get();
        $user = Auth::guard('member')->user();

        $bookingDate = session('booking_date');
        $bookingTime = session('booking_time');

        if (!$bookingDate || !$bookingTime) {
            return redirect()->route('cart.index')->with('error', 'กรุณาระบุเวลานัดหมายก่อน');
        }

        $shop_name = session('selected_shop_name');
        $branch_name = session('selected_branch_name');

        return view('frontend.checkout.index', compact('cart', 'branches', 'user', 'bookingDate', 'bookingTime', 'shop_name', 'branch_name'));
    }

    public function store(Request $request){
        $request->validate([
            'tel' => 'required',
            'car_brand' => 'required',
            'car_model' => 'required',
            'license_plate' => 'required',
            'branch_id' => 'required|exists:shops,id',
            'booking_date' => 'required',
            'booking_time' => 'required',
        ], [
            'tel.required' => 'กรุณาระบุเบอร์โทรศัพท์',
            'license_plate.required' => 'กรุณาระบุทะเบียนรถ',
            'branch_id.required' => 'กรุณาเลือกสาขา',
            'booking_date.required' => 'กรุณาเลือกวันที่นัดหมาย',
            'booking_time.required' => 'กรุณาเลือกเวลานัดหมาย',
        ]);

        $cart = session()->get('cart');
        if(!$cart) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        DB::beginTransaction();

        try {
            $grandTotal = 0;
            foreach($cart as $item) {
                $grandTotal += $item['price'] * $item['quantity'];
            }

            $bookingDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->booking_date)->format('Y-m-d');
            $carDetailString = $request->car_brand . ' ' . $request->car_model;

            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . rand(1000, 9999),
                'branch_id'    => $request->branch_id, 
                'name'          => $request->name,
                'tel'          => $request->tel,
                'car_detail'   => $carDetailString,
                'license_plate' => $request->license_plate,
                'booking_date' => $bookingDate,
                'booking_time' => $request->booking_time,
                'total_price'  => $grandTotal,
                
                'payment_method' => 'qrcode',  
                'payment_status' => 'pending', 
                'status'         => 'pending', 
            ]);

            foreach($cart as $id => $details) {
                OrderDetail::create([
                    'order_id'     => $order->id,
                    'product_id'   => $id,
                    'product_name' => $details['name'],
                    'price'        => $details['price'],
                    'quantity'     => $details['quantity'],
                    'total'        => $details['price'] * $details['quantity'],
                ]);
            }

            session()->forget('cart');
            DB::commit();
            return redirect()->route('checkout.payment', ['id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาดในการบันทึก: ' . $e->getMessage());
        }
    }

    public function payment($id){
        $order = Order::findOrFail($id);
        
        $qrImageBase64 = null;
        $errorMessage = null;
        try {
            $scbService = new ScbPaymentService();
            $qrImageBase64 = $scbService->generateQr($order->total_price, $order->order_number);
            return view('frontend.checkout.payment', compact('order', 'qrImageBase64'));

        } catch (\Exception $e) {
            $errorMessage = 'ไม่สามารถสร้าง QR Code ได้ในขณะนี้: ' . $e->getMessage();
            \Log::error("SCB QR Error Order #{$order->id}: " . $e->getMessage());
        }
        return view('frontend.checkout.payment', compact('order', 'qrImageBase64', 'errorMessage'));
    }

    public function success($id) {
        $order = Order::with('orderDetails')->findOrFail($id);
        if($order->member_id != Auth::guard('member')->id()){
             return redirect()->route('home');
        }

        return view('frontend.checkout.success', compact('order'));
    }

    public function checkStatus($id){
        $order = Order::findOrFail($id);
        return response()->json([
            'status' => $order->payment_status
        ]);
    }

    public function cancelOrder($id){
        $order = Order::find($id);
        if ($order) {
            $order->orderDetails()->delete(); 
            $order->delete();
            return redirect('/');
        }
        return response()->json(['status' => 'error'], 404);
    }
}
