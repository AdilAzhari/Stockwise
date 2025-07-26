<?php

namespace App\Observers;

use App\Models\Supplier;

class SupplierObserver
{
    /**
     * Handle the Supplier "creating" event.
     */
    public function creating(Supplier $supplier): void
    {
        if (empty($supplier->slug)) {
            $supplier->slug = Str()->slug($supplier->name);
        }
    }

    /**
     * Handle the Supplier "updating" event.
     */
    public function updating(Supplier $supplier): void
    {
        if ($supplier->isDirty('name')) {
            $supplier->slug = Str()->slug($supplier->name);
        }
    }
}
