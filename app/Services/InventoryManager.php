<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Exception;

class InventoryManager
{
    /**
     * @throws Exception
     */
    public function reduceStock(Product $product, int $quantity, ?string $reason = 'sale'): void
    {
        if ($product->stock_quantity < $quantity) {
            throw new Exception("Insufficient stock for $product->name.");
        }

        $product->decrement('stock_quantity', $quantity);

        StockMovement::query()->create([
            'product_id' => $product->id,
            'quantity' => -$quantity,
            'type' => 'out',
            'reason' => $reason,
        ]);
    }

    public function restoreStock(Product $product, int $quantity, ?string $reason = 'reversal'): void
    {
        $product->increment('stock_quantity', $quantity);

        StockMovement::query()->create([
            'product_id' => $product->id,
            'quantity' => $quantity,
            'type' => 'in',
            'reason' => $reason,
        ]);
    }
}
