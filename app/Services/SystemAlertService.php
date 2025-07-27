<?php

namespace App\Services;

use App\DTOs\Alert;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SystemAlertService
{
    public function getAlerts(): array
    {
        $alerts = [];

        // 🔸 Low Stock
        $lowStock = Product::query()->whereColumn('stock', '<=', 'alert_quantity')->get();
        if ($lowStock->count()) {
            $alerts[] = new Alert(
                type: 'warning',
                message: "{$lowStock->count()} product(s) are low in stock.",
                icon: 'exclamation-triangle',
                link: route('filament.admin.resources.products.index', ['tableFilters[LowStock]' => true]),
            );
        }

        // 🔸 Unpaid Invoices
        $overdueSales = Sale::query()
            ->where('is_paid', false)
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->count();

        if ($overdueSales > 0) {
            $alerts[] = new Alert(
                type: 'danger',
                message: "$overdueSales overdue unpaid sale(s).",
                icon: 'currency-dollar',
                link: route('filament.admin.resources.sales.index', ['tableFilters[Overdue]' => true]),
            );
        }

        // 🔸 Inactive Products
        $inactiveProducts = Product::query()->whereDoesntHave('sales', function ($query): void {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })->count();

        if ($inactiveProducts > 0) {
            $alerts[] = new Alert(
                type: 'info',
                message: "$inactiveProducts product(s) haven’t been sold in 30+ days.",
                icon: 'archive-box',
                link: route('filament.admin.resources.products.index'),
            );
        }

        // 🔸 Underperforming Cashiers
        $monthlySales = Sale::query()
            ->select('user_id', DB::raw('count(*) as sales_count'))
            ->whereMonth('created_at', now()->month)
            ->groupBy('user_id')
            ->get();

        $avgSales = $monthlySales->avg('sales_count');
        $lowPerformers = $monthlySales->filter(fn ($s) => $s->sales_count < ($avgSales * 0.5));

        foreach ($lowPerformers as $performer) {
            $user = User::query()->find($performer->user_id);
            if (! $user) {
                continue;
            }

            $alerts[] = new Alert(
                type: 'warning',
                message: "Cashier $user->name has low sales this month ($performer->sales_count only).",
                icon: 'user-minus',
                link: route('filament.admin.resources.sales.index', ['tableFilters[Cashier]' => $user->id]),
            );
        }

        return $alerts;
    }
}
