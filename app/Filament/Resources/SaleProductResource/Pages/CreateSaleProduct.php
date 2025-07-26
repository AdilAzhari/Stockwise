<?php

namespace App\Filament\Resources\SaleProductResource\Pages;

use App\Filament\Resources\SaleProductResource;
use App\Traits\HasNotifications;
use Filament\Resources\Pages\CreateRecord;

class CreateSaleProduct extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = SaleProductResource::class;
}
