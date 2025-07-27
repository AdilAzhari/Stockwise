<?php

namespace App\DTOs;

final readonly class UserContextDTO
{
    public function __construct(
        public int    $id,
        public string $role,
        public string $name,
    ) {}
}
