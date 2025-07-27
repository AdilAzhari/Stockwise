<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class SystemNotifications extends Widget
{
    protected static string $view = 'filament.widgets.system-notifications';

    public function getNotifications(): array
    {
        $lowStock = Product::query()->whereColumn('stock_quantity', '<=', 'alert_quantity')->get();

        $notifications = [];

        if ($lowStock->count()) {
            $notifications[] = [
                'type' => 'warning',
                'message' => trans_choice(
                    '{0} All products are sufficiently stocked.|{1} :count product is low in stock.|[2,*] :count products are low in stock.',
                    $lowStock->count(),
                    ['count' => $lowStock->count()]
                ),
                'link' => route('filament.admin.resources.products.index', ['tableFilters[LowStock]' => true]),
            ];
        }

        return $notifications;
    }

    protected function getViewData(): array
    {
        return [
            'notifications' => $this->getNotifications(),
        ];
    }
}
