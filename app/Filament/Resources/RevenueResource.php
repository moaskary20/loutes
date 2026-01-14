<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Filament\Resources\RevenueResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RevenueResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    
    protected static ?string $navigationLabel = 'الإيرادات';
    
    protected static ?string $modelLabel = 'إيراد';
    
    protected static ?string $pluralModelLabel = 'الإيرادات';

    protected static ?string $navigationGroup = 'الحسابات المالية';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // لا حاجة لنموذج لأننا نعرض فقط
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', OrderStatus::DELIVERED)
                    ->orderBy('created_at', 'desc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('المجموع الفرعي')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('الضريبة')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('الشحن')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('الخصم')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('طريقة الدفع')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('من تاريخ'),
                        Forms\Components\DatePicker::make('until')
                            ->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('طريقة الدفع')
                    ->options([
                        'cash' => 'نقدي',
                        'card' => 'بطاقة',
                        'bank_transfer' => 'تحويل بنكي',
                        'online' => 'دفع إلكتروني',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRevenues::route('/'),
        ];
    }
}
