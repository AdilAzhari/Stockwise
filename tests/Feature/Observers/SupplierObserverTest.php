<?php

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('generates a slug when creating a supplier', function (): void {
    $supplier = Supplier::query()->create([
        'name' => 'Test Supplier',
        'contact_name' => 'John Doe',
        'address' => '123 Main Street',
        'phone' => '123456789',
        'email' => 'test@example.com',
        'payment_terms' => '30 days',
    ]);

    expect($supplier->slug)->not()->toBeNull()
        ->and($supplier->slug)->toContain('test-supplier');
});
