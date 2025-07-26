<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\HasNotifications;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Product Created')
            ->body("{$this->record->name} has been added successfully.")
            ->success()
            ->send();
    }
}
