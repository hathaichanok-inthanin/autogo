<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\ContactUs;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    
    public function dashboard(Request $request) {
        $today = now()->toDateString();

        $totalSalesToday = Order::where('payment_status', 'paid')
                                ->whereDate('created_at', $today)
                                ->sum('total_price');

        $pendingPaymentCount = Order::where('payment_status', 'pending')->count();

        $pendingShippingCount = Order::where('payment_status', 'paid')
                                     ->where('status', 'pending') 
                                     ->count();

        $appointmentsCount = Order::whereDate('booking_date', $today)
                                  ->where('payment_status', 'paid')
                                  ->count();

        $todayOrders = Order::with(['shop', 'orderDetails'])
                             ->whereDate('created_at', $today)
                             ->paginate('10');

        $todayAppointments = Order::with(['shop', 'orderDetails'])
                                  ->whereDate('booking_date', $today)
                                  ->orderBy('booking_time', 'asc')
                                  ->paginate('10');

        return view('backend/dashboard', compact(
            'totalSalesToday',
            'pendingPaymentCount',
            'pendingShippingCount', 
            'appointmentsCount',
            'todayOrders',
            'todayAppointments'
        ));
    }

    public function message(Request $request) {
        $NUM_PAGE = 20;
        $messages = ContactUs::orderBy('id','desc')->paginate($NUM_PAGE);
        $page = $request->input('page', 1);
        return view('backend/message')->with('NUM_PAGE',$NUM_PAGE)
                                      ->with('page',$page)
                                      ->with('messages',$messages);
    }
}
