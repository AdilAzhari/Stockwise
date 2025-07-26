<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockEntryResource\Pages;
use App\Models\StockEntry;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class StockEntryResource extends Resource
{
    protected static ?string $model = StockEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationLabel = 'Stock Entries';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('quantity')
                    ->numeric()
                    ->required(),

                TextInput::make('cost_price')
                    ->label('Cost Price')
                    ->numeric()
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
                TextColumn::make('cost_price')->label('Cost Price')->money('MYR'),
                TextColumn::make('addedBy.name')->label('User'),
                TextColumn::make('created_at')->label('Date')->dateTime(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name'),

                Tables\Filters\SelectFilter::make('added_by')
                    ->label('User')
                    ->relationship('addedBy', 'name'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record): void {
                        Notification::make()
                            ->title('Product Deleted')
                            ->body("$record->name has been deleted.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function ($record): void {
                            Notification::make()
                                ->title('Stock Entries Deleted')
                                ->body("$record->name has been deleted.")
                                ->danger()
                                ->send();
                        }),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),

                    ExportBulkAction::make(),

                    BulkAction::make('set_note')
                        ->label('Set Note')
                        ->form([
                            Forms\Components\Textarea::make('note')
                                ->label('Note')
                                ->required(),
                        ])
                        ->action(function (array $records, array $data): void {
                            foreach ($records as $record) {
                                $record->update(['note' => $data['note']]);
                            }
                        })
                        ->requiresConfirmation()
                        ->color('secondary'),

                    ExportBulkAction::make()
                        ->label('Export')
                        ->exports([
                            //                            ExcelExport::make('excel'),
                            //                            CsvExport::make('csv'),
                            //                            PdfExport::make('pdf'),
                        ]),

                    BulkAction::make('update_cost_price')
                        ->label('Update Cost Price')
                        ->form([
                            TextInput::make('cost_price')
                                ->label('New Cost Price')
                                ->numeric()
                                ->required(),
                        ])
                        ->action(function (array $records, array $data): void {
                            foreach ($records as $record) {
                                $record->update(['cost_price' => $data['cost_price']]);
                            }
                        })
                        ->color('warning')
                        ->icon('heroicon-o-currency-dollar'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListStockEntries::route('/'),
            'create' => Pages\CreateStockEntry::route('/create'),
            'edit' => Pages\EditStockEntry::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['product', 'addedBy']);
    }
}
