<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use Exception;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-refund';

    protected static ?string $navigationLabel = 'Sales';

    protected static ?string $navigationGroup = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable(),

                TextInput::make('total_amount')
                    ->numeric()
                    ->required(),

                TextInput::make('paid_amount')
                    ->numeric()
                    ->required(),

                TextInput::make('outstanding_balance')
                    ->label('Balance')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (TextInput $component, $state, $record): void {
                        if ($record) {
                            $component->state($record->total_amount - $record->paid_amount);
                        }
                    }),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->disabled(fn ($get) => $get('paid_amount') < $get('total_amount')),

                Repeater::make('saleProducts')
                    ->label('Products')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required()
                            ->searchable(),

                        TextInput::make('quantity')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) => $set('total', $state * $get('price_at_sale'))
                            ),

                        TextInput::make('price_at_sale')
                            ->numeric()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $get, callable $set) => $set('total', $state * $get('quantity'))
                            ),

                        TextInput::make('total')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(4)
                    ->createItemButtonLabel('Add Product')
                    ->collapsible()
                    ->defaultItems(1),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sale ID')->sortable(),
                TextColumn::make('customer.name')->label('Customer')->searchable(),
                TextColumn::make('cashier.name')->label('Cashier')->searchable(),
                TextColumn::make('total_amount')->money('MYR', true)->sortable(),
                TextColumn::make('paid_amount')->money('MYR', true)->sortable(),
                TextColumn::make('outstanding_balance')
                    ->label('Balance')
                    ->getStateUsing(fn ($record) => $record->total_amount - $record->paid_amount)
                    ->money('MYR', true),
                BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
                Tables\Filters\Filter::make('Overdue')
                    ->query(fn ($query) => $query->where('is_paid', false)->where('created_at', '<', now()->subDays(7))),

                Tables\Filters\Filter::make('Cashier')
                    ->form([
                        Select::make('cashier_id')->relationship('user', 'name'),
                    ])
                    ->query(fn ($query, $data) => $query->where('user_id', $data['cashier_id'] ?? null)),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record): void {
                        Notification::make()
                            ->title('Sale Deleted')
                            ->body("$record->name has been deleted.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function ($record): void {
                        Notification::make()
                            ->title('Sales Deleted')
                            ->body("$record->name has been deleted.")
                            ->danger()
                            ->send();
                    }),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withTrashed();
    }
}
