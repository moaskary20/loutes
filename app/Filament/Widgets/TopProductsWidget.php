<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopProductsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->withCount('orderItems')
                    ->orderBy('order_items_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('المخزون')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_items_count')
                    ->label('عدد المبيعات')
                    ->counts('orderItems')
                    ->sortable(),
            ])
            ->heading('أفضل المنتجات مبيعاً');
    }
}
