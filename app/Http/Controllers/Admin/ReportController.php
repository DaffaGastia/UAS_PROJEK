<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FilterReportRequest;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.reports.index', compact('orders'));
    }

    public function downloadPdf()
    {
        $orders = Order::with('user')->latest()->get();
        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders'));
        return $pdf->download('laporan_penjualan.pdf');
    }
}
