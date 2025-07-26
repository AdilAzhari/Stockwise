<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     */
    public function creating(User $user): void
    {
        if (empty($user->name)) {
            $user->name = 'Anonymous User';
        }
    }
}
