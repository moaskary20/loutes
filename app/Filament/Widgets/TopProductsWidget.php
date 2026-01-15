<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Schema;

class TopProductsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $hasOrderItemsTable = Schema::hasTable('order_items');
        
        $query = Product::query();
        
        if ($hasOrderItemsTable) {
            try {
                $query->withCount('orderItems')
                      ->orderBy('order_items_count', 'desc');
            } catch (\Exception $e) {
                // If orderItems relationship fails, just order by name
                $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }
        
        $query->limit(10);
        
        $columns = [
            Tables\Columns\TextColumn::make('name')
                ->label('اسم المنتج')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('price')
                ->label('السعر')
                ->money('EGP')
                ->sortable(),
            Tables\Columns\TextColumn::make('stock_quantity')
                ->label('المخزون')
                ->sortable(),
        ];
        
        if ($hasOrderItemsTable) {
            try {
                $columns[] = Tables\Columns\TextColumn::make('order_items_count')
                    ->label('عدد المبيعات')
                    ->counts('orderItems')
                    ->sortable();
            } catch (\Exception $e) {
                // Skip order_items_count column if it fails
            }
        }
        
        return $table
            ->query($query)
            ->columns($columns)
            ->heading('أفضل المنتجات مبيعاً');
    }
}
