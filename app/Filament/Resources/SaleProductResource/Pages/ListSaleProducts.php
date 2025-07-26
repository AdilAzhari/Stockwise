<?php

namespace App\Filament\Resources\SaleProductResource\Pages;

use App\Filament\Resources\SaleProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaleProducts extends ListRecords
{
    protected static string $resource = SaleProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
