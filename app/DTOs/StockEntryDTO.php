<?php

namespace App\DTOs;

use App\Models\StockEntry;

final readonly class StockEntryDTO
{
    public function __construct(
        public readonly int     $added_by,
        public readonly float   $cost_price,
        public readonly string  $reference_number,
        public readonly int     $productId,
        public readonly int     $quantity,
        public readonly int     $supplierId,
        public readonly ?string $note = null,
    )
    {
    }
}
