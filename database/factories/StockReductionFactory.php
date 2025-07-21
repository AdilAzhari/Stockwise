<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockReduction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockReduction>
 */
class StockReductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => fake()->numberBetween(1, 20),
            'reason' => fake()->randomElement(['damage', 'transfer', 'adjustment']),
            'note' => fake()->sentence(),
            'user_id' => 1,
        ];
    }
}
