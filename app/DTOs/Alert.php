<?php

namespace App\DTOs;

class Alert
{
    public function __construct(
        public string $type,
        public string $message,
        public string $icon = 'information-circle',
        public ?string $link = null,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'icon' => $this->icon,
            'link' => $this->link,
        ];
    }

    public function badgeColor(): string
    {
        return match ($this->type) {
            'danger' => 'red',
            'warning' => 'yellow',
            'success' => 'green',
            'info' => 'blue',
            default => 'gray',
        };
    }
}
