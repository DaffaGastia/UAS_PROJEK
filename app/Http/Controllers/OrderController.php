<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', session('customer_id'))->get();
        return view('orders.index', compact('orders'));
    }
}
