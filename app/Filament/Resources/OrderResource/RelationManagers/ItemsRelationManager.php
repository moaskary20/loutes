<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'عناصر الطلب';

    protected static ?string $modelLabel = 'عنصر';

    protected static ?string $pluralModelLabel = 'العناصر';

    public function form(Form $form): Form
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
                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                        if ($state) {
                            $product = Product::find($state);
                            if ($product) {
                                $set('product_name', $product->name);
                                $set('product_sku', $product->sku);
                                $set('price', $product->price);
                                $quantity = $get('quantity') ?: 1;
                                $set('total', $product->price * $quantity);
                            }
                        }
                    }),
                Forms\Components\TextInput::make('product_name')
                    ->label('اسم المنتج')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('product_sku')
                    ->label('رمز المنتج')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->label('الكمية')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                        $price = $get('price') ?: 0;
                        $set('total', $price * $state);
                    }),
                Forms\Components\TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->required()
                    ->prefix('ج.م')
                    ->step(0.01)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                        $quantity = $get('quantity') ?: 1;
                        $set('total', $state * $quantity);
                    }),
                Forms\Components\TextInput::make('total')
                    ->label('الإجمالي')
                    ->numeric()
                    ->required()
                    ->prefix('ج.م')
                    ->step(0.01)
                    ->disabled()
                    ->dehydrated(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_sku')
                    ->label('رمز المنتج')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('EGP')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('المجموع الكلي')
                            ->money('EGP'),
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة منتج'),
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
            ->defaultSort('id');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // التأكد من حفظ اسم المنتج ورمز المنتج
        if (isset($data['product_id']) && !isset($data['product_name'])) {
            $product = Product::find($data['product_id']);
            if ($product) {
                $data['product_name'] = $product->name;
                $data['product_sku'] = $product->sku;
            }
        }

        return $data;
    }
}
