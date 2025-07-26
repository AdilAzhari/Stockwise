<?php

use App\Models\Product;
use App\Models\StockEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('automatically sets added_by when creating a stock entry', function (): void {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $entry = StockEntry::query()->create([
        'product_id' => $product->id,
        'quantity' => 10,
        'cost_price' => 20.50,
    ]);

    expect($entry->added_by)->toBe($user->id);
});
