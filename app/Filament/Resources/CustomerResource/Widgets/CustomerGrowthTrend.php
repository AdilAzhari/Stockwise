<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;

class CustomerGrowthTrend extends ChartWidget
{
    protected static ?string $heading = 'Customer Growth Trend';

    protected function getData(): array
    {
        $customers = Customer::query()->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => array_values($customers->toArray()),
                ],
            ],
            'labels' => array_keys($customers->toArray()),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
