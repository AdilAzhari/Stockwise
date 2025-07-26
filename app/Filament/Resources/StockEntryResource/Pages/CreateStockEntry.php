<?php

namespace App\Filament\Resources\StockEntryResource\Pages;

use App\Filament\Resources\StockEntryResource;
use App\Traits\HasNotifications;
use Filament\Resources\Pages\CreateRecord;

class CreateStockEntry extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = StockEntryResource::class;
}
