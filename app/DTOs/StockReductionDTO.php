<?php

namespace App\DTOs;

final readonly class StockReductionDTO
{
    public function __construct(
        public int     $productId,
        public int     $quantity,
        public string  $reason,
        public ?string $note = null,
    ) {}
}
