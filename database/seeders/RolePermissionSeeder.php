<?php

namespace Database\Seeders;

use App\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        foreach (UserRole::cases() as $role) {
            Role::query()->firstOrCreate(['name' => $role->value]);
        }

        // You must have filament shield installed for these to work
        $permissions = Permission::all();

        // Assign all permissions to admin
        Role::findByName(UserRole::ADMIN->value)->syncPermissions($permissions);

        // Limited cashier permissions
        Role::findByName(UserRole::CASHIER->value)->syncPermissions([
            'view_sale',
            'create_sale',
            'update_sale',
        ]);

        // Supervisor role - only view access
        Role::findByName(UserRole::SUPERVISOR->value)->syncPermissions([
            'view_product',
            'view_sale',
            'view_customer',
            'view_supplier',
        ]);
    }
}
