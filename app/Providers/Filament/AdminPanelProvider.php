<?php

namespace App\Providers\Filament;

use App\Filament\Resources\CustomerResource\Widgets\CustomerGrowthTrend;
use App\Filament\Resources\CustomerResource\Widgets\CustomerOverview;
use App\Filament\Resources\NonResource\Widgets\SupermartDashboard;
use App\Filament\Resources\ProductResource\Widgets\LowStockProducts;
use App\Filament\Resources\ProductResource\Widgets\TopProductsSold;
use App\Filament\Resources\SaleResource\Widgets\CashierPerformance;
use App\Filament\Resources\SaleResource\Widgets\MonthlyRevenueChart;
use App\Filament\Resources\SaleResource\Widgets\SalesByStatus;
use App\Filament\Resources\SaleResource\Widgets\SalesByStatusChart;
use App\Filament\Resources\SaleResource\Widgets\SalesOverview;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                SupermartDashboard::class,
                SalesOverview::class,
                SalesByStatus::class,
                CustomerOverview::class,
                TopProductsSold::class,
                MonthlyRevenueChart::class,
                CustomerGrowthTrend::class,
                CashierPerformance::class,
                LowStockProducts::class,
                SalesByStatusChart::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->resources([
                config('filament-logger.activity_resource'),
            ])
            ->brandName('Supermart Admin');
    }

    public function boot(): void {}
}
