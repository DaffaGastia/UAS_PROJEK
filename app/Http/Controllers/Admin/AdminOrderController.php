<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::with('user')->get()
        ]);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->find($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->status
        ]);
        return back()->with('success', 'Status berhasil diperbarui!');
    }

}
