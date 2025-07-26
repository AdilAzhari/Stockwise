<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Customer;

class CustomerOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Customers', Customer::count())
                ->description('All-time registered')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Card::make('New This Month', Customer::whereMonth('created_at', now()->month)->count())
                ->description('Recent growth')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Card::make('Soft Deleted', Customer::onlyTrashed()->count())
                ->description('In trash')
                ->descriptionIcon('heroicon-m-trash')
                ->color('danger'),
        ];
    }
}
