<?php

namespace App\DTOs;

use App\Models\StockEntry;

readonly class StockEntryDTO
{
    public function __construct(
        public int $id,
        public int $productId,
        public int $quantity,
        public float $costPrice,
        public string $addedByName
    ) {}

    public static function fromModel(StockEntry $entry): self
    {
        return new self(
            $entry->id,
            $entry->product_id,
            $entry->quantity,
            $entry->cost_price,
            $entry->addedBy?->name ?? 'System'
        );
    }
}
