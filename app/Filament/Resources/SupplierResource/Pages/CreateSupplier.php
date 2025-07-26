<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use App\Traits\HasNotifications;
use Filament\Resources\Pages\CreateRecord;

class CreateSupplier extends CreateRecord
{
    use HasNotifications;

    protected static string $resource = SupplierResource::class;
}
