<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Traits\HasNotifications;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = SaleResource::class;
}
