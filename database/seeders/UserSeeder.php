<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        User::factory(5)->create([
            'role' => UserRole::ADMIN->value,
        ]);

        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);

        // Create additional users
        User::factory(5)->create();
    }
}
