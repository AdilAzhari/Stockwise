<?php

namespace App\Filament\Resources;

use App\Exports\StockMovementExport;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Exception;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Z3d0X\FilamentLogger\Resources\ActivityResource\Pages\ListActivities;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Products';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord: true)
                    ->default(fn () => 'Will be auto-generated')
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('barcode')->required()->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->rows(3),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('buying_price')->numeric()->required(),

                TextInput::make('selling_price')->numeric()->required(),

                TextInput::make('cost_price')
                    ->label('Cost Price')
                    ->numeric()
                    ->required()
                    ->prefix('RM'),

                TextInput::make('unit_price')
                    ->label('Selling Price')
                    ->numeric()
                    ->required()
                    ->prefix('RM'),

                Toggle::make('is_active')->default(true),

                TextInput::make('unit')
                    ->required()
                    ->default('pcs')
                    ->placeholder('e.g. piece, kg, pack'),

                FileUpload::make('image_path')
                    ->label('Product Image')
                    ->image()
                    ->directory('products')
                    ->maxSize(2048)
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular()
                    ->size(40),

                TextColumn::make('name')->searchable()->sortable(),

                TextColumn::make('sku')->sortable(),

                TextColumn::make('category.name')->label('Category')->sortable(),

                TextColumn::make('supplier.name')->label('Supplier')->sortable(),

                TextColumn::make('cost_price')
                    ->money('myr', true)
                    ->label('Cost'),

                TextColumn::make('unit_price')
                    ->money('myr', true)
                    ->label('Price'),

                TextColumn::make('unit')->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record): void {
                        Notification::make()
                            ->title('Products Deleted')
                            ->body("$record->name has been deleted.")
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),

                    Action::make('Export Stock Movements')
                        ->action(fn () => Excel::download(new StockMovementExport, 'stock_movements.xlsx')),
                ]),
            ])->defaultSort('name');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'activities' => ListActivities::route('/{record}/logs'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
