<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the Product "creating" event.
     */
    public function creating(Product $product): void
    {
        if (Auth::check()) {
            $product->created_by = Auth::id();
            $product->updated_by = Auth::id();
        }

        if (empty($product->slug)) {
            $product->slug = str()->slug($product->name);
        }

        if (empty($product->sku)) {
            $prefix = str()->slug($product->name, '-');
            $random = strtoupper(str()->random(5));
            $product->sku = $prefix.'-'.$random;
        }
    }

    /**
     * Handle the Product "updating" event.
     */
    public function updating(Product $product): void
    {
        if (Auth::check()) {
            $product->updated_by = Auth::id();
        }

        if ($product->isDirty('name')) {
            $product->slug = str()->slug($product->name);
        }
    }
}
