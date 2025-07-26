<?php

namespace App\Filament\Resources\StockReductionResource\Pages;

use App\Filament\Resources\StockReductionResource;
use App\Traits\HasNotifications;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStockReduction extends EditRecord
{
    use HasNotifications;

    protected static string $resource = StockReductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
