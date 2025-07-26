<?php

namespace App\Filament\Resources\StockReductionResource\Pages;

use App\Filament\Resources\StockReductionResource;
use App\Traits\HasNotifications;
use Filament\Resources\Pages\CreateRecord;

class CreateStockReduction extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = StockReductionResource::class;
}
