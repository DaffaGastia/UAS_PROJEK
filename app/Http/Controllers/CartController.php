<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        $qty = $request->input('qty', 1); 
        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            $cart[$product_id]['qty'] += $qty;
        } 
        else {
            $cart[$product_id] = [
                'name'  => $product->name,
                'price' => $product->price,
                'qty'   => $qty,
                'image' => $product->image
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function updateQty(Request $request, $product_id)
    {
        $cart = session()->get('cart', []);
        if (!isset($cart[$product_id])) {
            return redirect()->back();
        }
        $newQty = $request->qty;
        if ($newQty < 1) {
            unset($cart[$product_id]);
        } else {
            $cart[$product_id]['qty'] = $newQty;
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Jumlah produk diperbarui.');
    }

    public function remove($product_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
