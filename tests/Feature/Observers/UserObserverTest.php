<?php

use App\Models\User;

it('ensures role is not null when creating a user', function (): void {
    $user = User::factory()->create();
    expect($user->role)->not()->toBeNull();
});
