<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function checkoutForm()
    {
        return view('orders.checkout');
    }

    public function processCheckout(Request $request)
    {
        if (!session('customer_id')) {
            return redirect('/login');
        }
        $cart = session('cart', []);
        if (count($cart) == 0) {
            return back()->with('error', 'Keranjang kosong');
        }
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $order = Order::create([
            'user_id' => session('customer_id'),
            'total_price' => $total,
            'status' => 'pending'
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'qty' => $item['qty'],
                'price' => $item['price']
            ]);

            Product::where('id', $productId)->decrement('stock', $item['qty']);
        }
            session()->forget('cart');
            return redirect()->route('payments.create', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan pilih metode pembayaran.');
    }
}
