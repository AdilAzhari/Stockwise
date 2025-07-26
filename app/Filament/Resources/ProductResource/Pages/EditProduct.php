<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\HasNotifications;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use HasNotifications;

    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\DeleteAction::make(),
        ];
    }
}
