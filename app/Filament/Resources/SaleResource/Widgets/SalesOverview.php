<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class SalesOverview extends ChartWidget
{
    protected static ?string $heading = 'Sales Overview';

    protected static ?int $sort = 1;

    protected function getData(): array
    {
        $data = Sale::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->take(14)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'data' => $data->pluck('total_sales'),
                    'borderColor' => '#6366f1', // Indigo
                    'backgroundColor' => 'rgba(99, 102, 241, 0.2)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('date')->map(fn ($date) => date('M d', strtotime($date))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
