<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesByStatus extends ChartWidget
{
    protected static ?string $heading = 'Sales by Status';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $statuses = Sale::query()->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'datasets' => [
                [
                    'data' => $statuses->values(),
                    'backgroundColor' => [
                        '#10B981', // success
                        '#F59E0B', // warning
                        '#EF4444', // danger
                        '#3B82F6', // info
                    ],
                ],
            ],
            'labels' => $statuses->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
