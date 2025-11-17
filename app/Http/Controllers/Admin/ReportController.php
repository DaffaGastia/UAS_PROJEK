<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->get();
        $summary = [
            'total_orders' => $orders->count(),
            'total_items'  => $orders->sum(function($order) {
                return $order->items->sum('qty');
            }),
            'total_income' => $orders->sum('total_price'),
        ];
        return view('admin.reports.index', compact('orders', 'summary'));
    }

    public function downloadPdf()
    {
        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 180);
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        $summary = [
            'total_orders' => $orders->count(),
            'total_items'  => $orders->sum(function($order) {
                return $order->items->sum('qty');
            }),
            'total_income' => $orders->sum('total_price'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf', [
                    'orders' => $orders,
                    'summary' => $summary
                ])
                ->setPaper('A4', 'portrait')
                ->setWarnings(false);

        return $pdf->download('laporan_penjualan.pdf');
    }
}
