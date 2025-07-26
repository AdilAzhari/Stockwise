<?php

use App\Models\Product;
use App\Models\User;

it('sets created_by and updated_by when creating product', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    expect($product->created_by)->toBe($user->id)
        ->and($product->updated_by)->toBe($user->id);
});

it('sets updated_by when updating product', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $product = Product::factory()->create();
    $product->name = 'Updated Name';
    $product->save();
    expect($product->updated_by)->toBe($user->id);
});
