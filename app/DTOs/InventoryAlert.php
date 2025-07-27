<?php

namespace App\DTOs;

use Carbon\Carbon;

class InventoryAlert
{
    public function __construct(
        public string $productName,
        public int $stock,
        public int $alertThreshold,
        public ?Carbon $lastSoldAt = null,
    ) {}

    public function toArray(): array
    {
        return [
            'productName' => $this->productName,
            'stock' => $this->stock,
            'threshold' => $this->alertThreshold,
            'lastSoldAt' => $this->lastSoldAt?->toDateString(),
            'status' => $this->stock <= $this->alertThreshold ? 'low' : 'ok',
        ];
    }

    public function isStale(): bool
    {
        return $this->lastSoldAt?->lt(now()->subDays(30));
    }
}
