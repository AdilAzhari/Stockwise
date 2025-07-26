<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'role' => UserRole::ADMIN,
        ]);
        $this->call([
            CategorySeeder::class,
            CustomerSeeder::class,
            SupplierSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
            StockMovementSeeder::class,
        ]);
    }
}
