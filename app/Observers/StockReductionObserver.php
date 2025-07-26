<?php

namespace App\Observers;

use App\Models\StockReduction;
use Illuminate\Support\Facades\Auth;

class StockReductionObserver
{
    /**
     * Handle the StockReduction "creating" event.
     */
    public function creating(StockReduction $reduction): void
    {
        if (Auth::check()) {
            $reduction->user_id = Auth::id();
        }

        // Auto-flag if reduction reason is missing
        if (empty($reduction->reason)) {
            $reduction->reason = 'manual_adjustment';
        }
    }

    /**
     * Handle the StockReduction "updating" event.
     */
    public function updating(StockReduction $stockReduction): void
    {
        if (auth()->id()) {
            $stockReduction->user_id = auth()->id();
        }
    }
}
