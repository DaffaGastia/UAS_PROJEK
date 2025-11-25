<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        foreach ($orders as $order) {
            $itemsCount = rand(1, 3);

            for ($i = 0; $i < $itemsCount; $i++) {
                $product = $products->random();

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => rand(1, 3),
                    'price' => $product->price
                ]);
            }

            
            $order->update([
                'total_price' => $order->items->sum(fn($i) => $i->qty * $i->price)
            ]);
        }
    }
}
