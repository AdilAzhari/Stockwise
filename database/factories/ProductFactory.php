<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'sku' => fake()->unique()->ean8(),
            'description' => fake()->sentence(),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'cost_price' => fake()->randomFloat(2, 1, 50),
            'unit_price' => fake()->randomFloat(2, 10, 100),
            'unit' => fake()->randomElement(['piece', 'kg', 'pack']),
            'image_path' => null,
            'barcode' => fake()->ean13(),
            'buying_price' => fake()->randomFloat(2, 1, 50),
            'selling_price' => fake()->randomFloat(2, 51, 100),
            'stock_quantity' => fake()->numberBetween(0, 200),
            'is_active' => true,
        ];
    }

}
