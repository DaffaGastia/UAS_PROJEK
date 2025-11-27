<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('payments.create', compact('order'));
    }

    public function store(Request $request, $order_id)
    {
        $request->validate([
            'method' => 'required|string',
            'details' => 'nullable|string'
        ]);

        $order = Order::findOrFail($order_id);

        if ($request->input('method') === 'COD') {
            $paymentStatus = 'pending';
            $orderStatus   = 'diproses';
        } else {
            $paymentStatus = 'success';
            $orderStatus   = 'diproses';
        }

        Payment::create([
            'order_id' => $order->id,
            'method'   => $request->input('method'),
            'details'  => $request->input('details'),
            'status'   => $paymentStatus,
        ]);

        $order->update([
            'payment_method' => $request->input('method'),
            'payment_status' => $paymentStatus,
            'status'         => $orderStatus,
        ]);

        return redirect()->route('checkout.success')
            ->with('success', 'Pembayaran berhasil diproses!');
    }
}
