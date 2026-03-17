<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shop;
use App\Models\Order;

class AccountingReportController extends Controller
{
    public function reportSale(Request $request) {
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());
        $branchId = $request->get('branch_id', 'all');

        $shops = Shop::where('is_active', '1')->get();

        $query = Order::where('payment_status', 'paid')
                    ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($branchId !== 'all') {
            $query->where('branch_id', $branchId);
        }

        $totalSales = $query->sum('total_price');
        $totalOrders = $query->count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        $chartData = $query->selectRaw('DATE(created_at) as date, SUM(total_price) as sum')
                        ->groupBy('date')
                        ->orderBy('date', 'asc')
                        ->get();

        return view('backend/accounting_report/report_sale', compact(
            'shops', 'totalSales', 'totalOrders', 'avgOrderValue', 'chartData', 'startDate', 'endDate', 'branchId',
        ));
    }

}
