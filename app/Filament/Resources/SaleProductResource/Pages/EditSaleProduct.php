<?php

namespace App\Filament\Resources\SaleProductResource\Pages;

use App\Filament\Resources\SaleProductResource;
use App\Traits\HasNotifications;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSaleProduct extends EditRecord
{
    use HasNotifications;

    protected static string $resource = SaleProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
