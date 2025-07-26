<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockProducts extends BaseWidget
{
    protected static ?string $heading = '📦 Low Stock Products';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock_quantity', '<', 10)
                    ->orderBy('stock_quantity')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable(),

                TextColumn::make('stock')
                    ->label('Remaining Stock')
                    ->sortable()
                    ->color('danger'),
            ]);
    }
}
