<?php

namespace App\DTOs;

final readonly class ProductDTO
{
    public function __construct(
        public string  $name,
        public string  $sku,
        public float   $price,
        public int     $categoryId,
        public ?string $description = null,
        public ?string $barcode = null,
    ) {}
}
