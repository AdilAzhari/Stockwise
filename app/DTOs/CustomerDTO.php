<?php

namespace App\DTOs;

final readonly class CustomerDTO
{
    public function __construct(
        public string  $name,
        public string  $phone,
        public ?string $email = null,
        public ?string $address = null,
    ) {}
}
