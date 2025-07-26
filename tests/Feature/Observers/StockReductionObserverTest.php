<?php

use App\Models\Product;
use App\Models\StockReduction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('automatically sets user_id when creating a stock reduction', function (): void {
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $this->actingAs($user);

    $reduction = StockReduction::query()->create([
        'product_id' => $product->id,
        'quantity' => 5,
        'reason' => 'damage',
        'user_id' => $user->id,
    ]);

    expect($reduction->user_id)->toBe($user->id);
});
