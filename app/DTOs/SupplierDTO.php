<?php

namespace App\DTOs;

final readonly class SupplierDTO
{
    public function __construct(
        public string  $name,
        public string  $phone,
        public ?string $company = null,
        public ?string $note = null,
    ) {}
}
