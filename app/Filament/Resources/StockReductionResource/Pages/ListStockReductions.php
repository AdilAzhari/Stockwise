<?php

namespace App\Filament\Resources\StockReductionResource\Pages;

use App\Filament\Resources\StockReductionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockReductions extends ListRecords
{
    protected static string $resource = StockReductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
