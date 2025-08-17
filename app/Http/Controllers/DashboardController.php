<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function report(Request $request)
    {
        $start = $request->start_date;
        $end   = $request->end_date;
        $orders = Order::with(['user', 'courier'])
            ->withSum('orderItems as total_qty', 'quantity')
            ->whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'asc')
            ->get();
         $data = [
            'orders' => $orders,
            'start'  => $start,
            'end'    => $end,
        ];

         $pdf = PDF::loadView('reports.orders', $data);
        return $pdf->download('report_orders_'.$start.'_to_'.$end.'.pdf');
    }
}
