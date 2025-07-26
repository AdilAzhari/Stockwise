<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockEntry>
 */
class StockEntryFactory extends Factory
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
            'quantity' => fake()->numberBetween(10, 100),
            'cost_price' => fake()->randomFloat(2, 5, 50),
            'added_by' => \App\Models\User::factory(),
            'received_at' => now(),
            'expiry_date' => now()->addDays(rand(30, 365)),
        ];
    }
}
