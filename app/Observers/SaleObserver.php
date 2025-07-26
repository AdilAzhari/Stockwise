<?php

namespace App\Observers;

use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */
    public function creating(Sale $sale): void
    {
        if (Auth::check()) {
            $sale->user_id = Auth::id();
        }

        // Auto-generate status or timestamps if needed
        if (empty($sale->status)) {
            $sale->status = 'pending';
        }
    }

    /**
     * Handle the Sale "updating" event.
     */
    public function updating(Sale $sale): void
    {
        // Sync status or perform auto-updates
        //        if ($sale->isDirty('is_paid') && $sale->is_paid) {
        //            $sale->paid_at = now();
        //        }

        if (Auth::check()) {
            $sale->user_id = Auth::id();
        }
    }
}
