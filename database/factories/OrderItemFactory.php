<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        // create a product so we can use its price reliably
        $product = Product::factory()->create();

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'qty' => $this->faker->numberBetween(1, 5),
            'price' => $product->price, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
