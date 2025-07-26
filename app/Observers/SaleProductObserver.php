<?php

namespace App\Observers;

use App\Models\SaleProduct;
use App\Services\InventoryManager;
use Exception;

class SaleProductObserver
{
    /**
     * @throws Exception
     */
    public function created(SaleProduct $saleProduct): void
    {
        app(InventoryManager::class)->reduceStock(
            $saleProduct->product,
            $saleProduct->quantity,
        );

    }

    public function deleted(SaleProduct $saleProduct): void
    {
        app(InventoryManager::class)->restoreStock(
            $saleProduct->product,
            $saleProduct->quantity,
            'sale_cancelled'
        );
    }

    /**
     * @throws Exception
     */
    public function updated(SaleProduct $saleProduct): void
    {
        if ($saleProduct->isDirty('quantity')) {
            $originalQty = $saleProduct->getOriginal('quantity');
            $newQty = $saleProduct->quantity;
            $diff = $newQty - $originalQty;

            if ($diff > 0) {
                app(InventoryManager::class)->reduceStock($saleProduct->product, $diff, 'sale_updated');
            } elseif ($diff < 0) {
                app(InventoryManager::class)->restoreStock($saleProduct->product, abs($diff), 'sale_updated');
            }
        }
    }
}
