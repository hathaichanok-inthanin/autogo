<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Partner;

use Auth;

class StaffDashboardController extends Controller
{
    public function dashboard(Request $request) {
        $today = now()->toDateString();

        $shop_id = Partner::where('id',Auth::guard('staff')->user()->partner_id)->value('shop_id');

        $totalSalesToday = Order::where('branch_id',$shop_id)
                                ->where('payment_status', 'paid')
                                ->whereDate('created_at', $today)
                                ->sum('total_price');

        $pendingPaymentCount = Order::where('branch_id',$shop_id)
                                    ->where('payment_status', 'pending')
                                    ->count();

        $pendingShippingCount = Order::where('branch_id',$shop_id)
                                     ->where('payment_status', 'paid')
                                     ->where('status', 'pending') 
                                     ->count();

        $appointmentsCount = Order::where('branch_id',$shop_id)
                                  ->whereDate('booking_date', $today)
                                  ->where('payment_status', 'paid')
                                  ->count();

        $todayOrders = Order::with(['shop', 'orderDetails'])
                             ->where('branch_id',$shop_id)
                             ->whereDate('created_at', $today)
                             ->get();

        $todayAppointments = Order::with(['shop', 'orderDetails'])
                                  ->where('branch_id',$shop_id)
                                  ->whereDate('booking_date', $today)
                                  ->orderBy('booking_time', 'asc')
                                  ->get();

        return view('backend/staff/dashboard', compact(
            'totalSalesToday',
            'pendingPaymentCount',
            'pendingShippingCount', 
            'appointmentsCount',
            'todayOrders',
            'todayAppointments'
        ));
    }
}
