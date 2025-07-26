<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleProductResource\Pages;
use App\Models\SaleProduct;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;

class SaleProductResource extends Resource
{
    protected static ?string $model = SaleProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?string $navigationLabel = 'Sale Products';

    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sale_id')
                    ->relationship('sale', 'id')
                    ->required()
                    ->label('Sale'),

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('Product'),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->minValue(1)
                    ->required(),

                Forms\Components\TextInput::make('price_at_sale')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('RM')
                    ->required(),

                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->step(0.01)
                    ->prefix('RM')
                    ->required()
                    ->helperText('Calculated automatically in real app logic.'),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sale.id')->label('Sale ID')->sortable(),
                TextColumn::make('product.name')->label('Product')->searchable(),

                BadgeColumn::make('quantity')
                    ->label('Qty')
                    ->colors([
                        'danger' => fn ($state) => $state < 5,
                        'warning' => fn ($state) => $state < 10,
                        'success' => fn ($state) => $state >= 10,
                    ]),

                TextColumn::make('price_at_sale')
                    ->money('MYR', true)
                    ->sortable(),

                TextColumn::make('total')
                    ->money('MYR', true)
                    ->sortable(),

                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (): void {
                            Notification::make()
                                ->title('Sale Products deleted')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSaleProducts::route('/'),
            'create' => Pages\CreateSaleProduct::route('/create'),
            'edit' => Pages\EditSaleProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
