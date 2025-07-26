<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalAmount = fake()->randomFloat(2, 100, 1000);
        $paidAmount = fake()->randomFloat(2, 0, $totalAmount);
        $status = $paidAmount >= $totalAmount ? 'paid' : ($paidAmount > 0 ? 'partial' : 'unpaid');

        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'status' => $status,
        ];
    }
}
