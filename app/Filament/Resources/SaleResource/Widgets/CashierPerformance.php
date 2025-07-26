<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Widgets\ChartWidget;

class CashierPerformance extends ChartWidget
{
    protected static ?string $heading = 'Cashier Performance';

    protected int|string|array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.quick-actions';

    protected function getData(): array
    {
        $cashierSales = Sale::query()->with('cashier')
            ->selectRaw('user_id, COUNT(*) as sales_count')
            ->groupBy('user_id')
            ->orderByDesc('sales_count')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'data' => $cashierSales->pluck('total')->toArray(),
                    'backgroundColor' => '#6366F1',
                ],
            ],
            'labels' => $cashierSales->map(fn ($s) => $s->cashier?->name ?? 'N/A')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
