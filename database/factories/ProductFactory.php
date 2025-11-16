<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Roti Coklat', 'Roti Keju', 'Roti Sobek', 'Roti Tawar', 'Roti Kismis']),
            'price' => $this->faker->numberBetween(5000, 25000),
            'stock' => $this->faker->numberBetween(5, 120),
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
