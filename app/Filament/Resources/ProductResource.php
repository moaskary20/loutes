<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'المنتجات';
    
    protected static ?string $modelLabel = 'منتج';
    
    protected static ?string $pluralModelLabel = 'المنتجات';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات المنتج')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم (عربي)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_en')
                            ->label('الاسم (إنجليزي)')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sku')
                            ->label('رمز المنتج')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->label('الفئة')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('short_description')
                            ->label('وصف مختصر')
                            ->rows(2),
                        Forms\Components\RichEditor::make('description')
                            ->label('الوصف الكامل')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make('الأسعار والمخزون')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('السعر بعد الخصم')
                            ->required()
                            ->numeric()
                            ->prefix('ج.م')
                            ->step(0.01),
                        Forms\Components\TextInput::make('compare_price')
                            ->label('السعر الأصلي')
                            ->numeric()
                            ->prefix('ج.م')
                            ->step(0.01),
                        Forms\Components\TextInput::make('cost_price')
                            ->label('سعر التكلفة')
                            ->numeric()
                            ->prefix('ج.م')
                            ->step(0.01),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('الكمية المتوفرة')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('low_stock_threshold')
                            ->label('حد التنبيه للمخزون')
                            ->numeric()
                            ->default(5),
                    ])->columns(5),
                Forms\Components\Section::make('المواصفات')
                    ->schema([
                        Forms\Components\TextInput::make('weight')
                            ->label('الوزن (كجم)')
                            ->numeric()
                            ->step(0.01),
                        Forms\Components\TextInput::make('dimensions')
                            ->label('الأبعاد')
                            ->maxLength(255)
                            ->placeholder('مثال: 10x20x30'),
                    ])->columns(2),
                Forms\Components\Section::make('صور المنتج')
                    ->schema([
                        Forms\Components\FileUpload::make('product_images')
                            ->label('رفع صور المنتج')
                            ->image()
                            ->directory('products')
                            ->multiple()
                            ->imageEditor()
                            ->reorderable()
                            ->helperText('يمكنك رفع صورة واحدة أو أكثر. الصورة الأولى ستكون الصورة الأساسية.')
                            ->columnSpanFull()
                            ->visible(fn ($livewire) => $livewire instanceof \App\Filament\Resources\ProductResource\Pages\CreateProduct),
                    ])
                    ->collapsible()
                    ->visible(fn ($livewire) => $livewire instanceof \App\Filament\Resources\ProductResource\Pages\CreateProduct),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('مميز'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('رمز المنتج')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('المخزون')
                    ->sortable()
                    ->color(fn ($record) => match (true) {
                        $record->stock_quantity <= 0 => 'danger',
                        $record->stock_quantity <= $record->low_stock_threshold => 'warning',
                        default => 'success',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('نشط')
                    ->placeholder('الكل')
                    ->trueLabel('نشط فقط')
                    ->falseLabel('غير نشط فقط'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('مميز')
                    ->placeholder('الكل')
                    ->trueLabel('مميز فقط')
                    ->falseLabel('غير مميز'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('الفئة')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('low_stock')
                    ->label('مخزون منخفض')
                    ->query(fn ($query) => $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
