<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryLogResource\Pages;
use App\Models\InventoryLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InventoryLogResource extends Resource
{
    protected static ?string $model = InventoryLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    
    protected static ?string $navigationLabel = 'سجل المخزون';
    
    protected static ?string $modelLabel = 'سجل مخزون';
    
    protected static ?string $pluralModelLabel = 'سجلات المخزون';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('المنتج')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            $product = \App\Models\Product::find($state);
                            if ($product) {
                                $set('current_stock', $product->stock_quantity);
                            }
                        }
                    }),
                Forms\Components\Placeholder::make('current_stock')
                    ->label('المخزون الحالي')
                    ->content(fn ($get) => $get('product_id') ? 
                        \App\Models\Product::find($get('product_id'))?->stock_quantity ?? 'غير محدد' 
                        : 'اختر منتج أولاً')
                    ->visible(fn ($get) => $get('product_id')),
                Forms\Components\TextInput::make('quantity')
                    ->label('الكمية')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\Select::make('type')
                    ->label('النوع')
                    ->options([
                        'in' => 'إضافة',
                        'out' => 'خصم',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                        if ($state && $get('product_id') && $get('quantity')) {
                            $product = \App\Models\Product::find($get('product_id'));
                            if ($product) {
                                $newStock = $state === 'in' 
                                    ? $product->stock_quantity + $get('quantity')
                                    : max(0, $product->stock_quantity - $get('quantity'));
                                $set('new_stock', $newStock);
                            }
                        }
                    }),
                Forms\Components\Placeholder::make('new_stock')
                    ->label('المخزون بعد التحديث')
                    ->content(function ($get) {
                        if (!$get('product_id') || !$get('quantity') || !$get('type')) {
                            return 'أكمل البيانات أولاً';
                        }
                        $product = \App\Models\Product::find($get('product_id'));
                        if (!$product) {
                            return 'غير محدد';
                        }
                        
                        $newStock = $get('type') === 'in' 
                            ? $product->stock_quantity + $get('quantity')
                            : max(0, $product->stock_quantity - $get('quantity'));
                        return $newStock;
                    })
                    ->visible(fn ($get) => $get('product_id') && $get('quantity') && $get('type')),
                Forms\Components\TextInput::make('reason')
                    ->label('السبب')
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference')
                    ->label('المرجع')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('product'))
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable()
                    ->placeholder('--'),
                Tables\Columns\TextColumn::make('product.stock_quantity')
                    ->label('المخزون الحالي')
                    ->sortable()
                    ->color(function ($record) {
                        if (!$record->product) {
                            return null;
                        }
                        if ($record->product->stock_quantity <= 0) {
                            return 'danger';
                        }
                        if ($record->product->stock_quantity <= $record->product->low_stock_threshold) {
                            return 'warning';
                        }
                        return 'success';
                    })
                    ->placeholder('--'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('reason')
                    ->label('السبب')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options([
                        'in' => 'إضافة',
                        'out' => 'خصم',
                    ]),
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('المنتج')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryLogs::route('/'),
            'create' => Pages\CreateInventoryLog::route('/create'),
            'edit' => Pages\EditInventoryLog::route('/{record}/edit'),
        ];
    }
}
