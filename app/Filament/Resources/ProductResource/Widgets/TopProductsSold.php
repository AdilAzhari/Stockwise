<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\SaleProduct;
use Filament\Widgets\ChartWidget;

class TopProductsSold extends ChartWidget
{
    protected static ?string $heading = 'Top Products Sold';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $topProducts = SaleProduct::query()->selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->with('product')
            ->limit(10)
            ->get();

        $labels = $topProducts->map(fn ($item) => optional($item->product)->name ?? 'N/A');
        $data = $topProducts->pluck('total_sold');

        return [
            'datasets' => [
                [
                    'label' => 'Units Sold',
                    'data' => $data,
                    'backgroundColor' => '#6366F1', // Tailwind Indigo
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
