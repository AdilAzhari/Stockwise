<?php

use App\Models\Sale;
use App\Models\User;

it('sets cashier_id when creating sale', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $sale = Sale::factory()->create();
    expect($sale->user_id)->toBe($user->id);
});
