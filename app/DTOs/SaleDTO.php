<?php
namespace App\DTOs;

final readonly class SaleDTO
{
    public function __construct(
        public int     $customerId,
        public int     $cashierId,
        public array   $products,
        public string  $status,
        public ?string $notes = null,
    ) {}
}
