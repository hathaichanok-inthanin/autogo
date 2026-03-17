<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Shop;
use App\Models\Partner;

use Auth;

class StaffOrderController extends Controller
{
    public function orders(Request $request) {
        $shop_id = Partner::where('id',Auth::guard('staff')->user()->partner_id)->value('shop_id');

        $query = Order::with(['shop', 'orderDetails'])
                      ->where('branch_id',$shop_id)
                      ->where('payment_status','paid')
                      ->where('status','pending')
                      ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                ->orWhere('car_detail', 'like', "%{$keyword}%") 
                ->orWhere('name', 'like', "%{$keyword}%") 
                ->orWhere('tel', 'like', "%{$keyword}%");
            });
        }

        $orders = $query->paginate(10);

        return view('backend.staff.orders.index', compact(
            'orders',
        ));
    }

    public function approvePayment($id){
        $order = Order::findOrFail($id);
        
        $order->payment_status = 'paid';  
        $order->status = 'confirmed';   
        $order->save();
        
        return redirect()->back()->with('success', 'อนุมัติยอดเงินเรียบร้อยแล้ว');
    }

    public function pendingPayment() {
        $shop_id = Partner::where('id',Auth::guard('staff')->user()->partner_id)->value('shop_id');

        $orders = Order::with(['orderDetails', 'shop'])
                    ->where('branch_id',$shop_id)
                    ->where('payment_status', 'pending')
                    ->orderBy('created_at', 'asc') 
                    ->paginate(10);

        return view('backend.staff.orders.pending', compact(
            'orders', 
        ));
    }

    public function appointments(Request $request) {
        $shops = Shop::where('is_active','1')->get();
        $shop_id = Partner::where('id',Auth::guard('staff')->user()->partner_id)->value('shop_id');

        $query = Order::with(['shop', 'orderDetails'])
                      ->where('branch_id',$shop_id)
                      ->where('payment_status','paid')
                      ->where('status','pending')
                      ->orderBy('created_at','desc');

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } 

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('license_plate', 'like', "%{$search}%")
                ->orWhere('tel', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')
                        ->paginate(10)
                        ->appends($request->all());
        return view('backend.staff.orders.appointments', compact('orders','shops'));
    }

    public function confirmStatus(Request $request, $id) {
        $order = Order::findOrFail($id);
        $order->status = "completed";
        $order->update();
        return back();
    }

    public function history(Request $request) {
        $shop_id = Partner::where('id',Auth::guard('staff')->user()->partner_id)->value('shop_id');

        $query = Order::with(['shop', 'orderDetails'])
                      ->where('branch_id',$shop_id)
                      ->where('payment_status','paid')
                      ->where('status','completed')
                      ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('order_number', 'like', "%{$keyword}%")
                ->orWhere('car_detail', 'like', "%{$keyword}%") 
                ->orWhere('name', 'like', "%{$keyword}%") 
                ->orWhere('tel', 'like', "%{$keyword}%");
            });
        }

        $orders = $query->paginate(10);

        return view('backend.staff.orders.history', compact(
            'orders',
        ));
    }
}
