<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            // by default create a new customer user; override by passing user_id when needed
            'user_id' => User::factory(),
            'total_price' => 0, // biasanya akan diupdate setelah order_items dibuat
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
