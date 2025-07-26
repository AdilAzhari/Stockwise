<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockReductionResource\Pages;
use App\Models\StockReduction;
use Exception;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StockReductionResource extends Resource
{
    protected static ?string $model = StockReduction::class;

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    protected static ?string $navigationLabel = 'Stock Reductions';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('product_id')
                ->label('Product')
                ->relationship('product', 'name')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('quantity')
                ->numeric()
                ->required(),

            Select::make('reason')
                ->options([
                    'damage' => 'Damage',
                    'transfer' => 'Transfer',
                    'adjustment' => 'Adjustment',
                ])
                ->required(),

            Textarea::make('note')
                ->rows(3),
        ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->label('Product')->searchable(),
                TextColumn::make('quantity'),
                TextColumn::make('reason')->badge()->colors([
                    'damage' => 'danger',
                    'transfer' => 'info',
                    'adjustment' => 'warning',
                ]),
                //                TextColumn::make('addedBy.name')->label('User'),
                TextColumn::make('created_at')->label('Date')->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('reason')
                    ->options([
                        'damage' => 'Damage',
                        'transfer' => 'Transfer',
                        'adjustment' => 'Adjustment',
                    ])
                    ->label('Reason'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record): void {
                        Notification::make()
                            ->title('Stock Reductions Deleted')
                            ->body("$record->name has been deleted.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockReductions::route('/'),
            'create' => Pages\CreateStockReduction::route('/create'),
            'edit' => Pages\EditStockReduction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['product', 'addedBy']);
    }
}
