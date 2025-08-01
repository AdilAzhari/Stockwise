<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SaleProduct>
 */
class SaleProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5); // Reduced to avoid stock issues
        $priceAtSale = fake()->randomFloat(2, 10, 100);
        $total = $quantity * $priceAtSale;

        return [
            'sale_id' => Sale::factory(),
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'price_at_sale' => $priceAtSale,
            'total' => $total,
        ];
    }
}
