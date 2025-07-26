<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\ChartWidget;

class CustomerOverview extends ChartWidget
{
    protected static ?string $heading = '📈 Monthly Customer Growth';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $monthlyData = Customer::query()->selectRaw('COUNT(*) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'New Customers',
                    'data' => $monthlyData->values(),
                    'borderColor' => '#4f46e5', // Indigo
                    'backgroundColor' => 'rgba(79,70,229,0.2)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
            'labels' => $monthlyData->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
