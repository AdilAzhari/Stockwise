<?php

namespace App\Observers;

use App\Models\StockEntry;
use Illuminate\Support\Facades\Auth;

class StockEntryObserver
{
    /**
     * Handle the StockEntry "creating" event.
     */
    public function creating(StockEntry $entry): void
    {
        if (Auth::check()) {
            $entry->added_by = Auth::id();
        }

        // Auto-generate reference number if missing
        if (empty($entry->reference_number)) {
            $entry->reference_number = 'SE-'.now()->format('Ymd-His').'-'.str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Handle the StockEntry "updated" event.
     */
    public function updating(StockEntry $entry): void
    {
        if (Auth::check()) {
            $entry->added_by = Auth::id();
        }
    }
}
