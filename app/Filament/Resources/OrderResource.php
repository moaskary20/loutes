<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\PaymentMethod;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'الطلبات';
    
    protected static ?string $modelLabel = 'طلب';
    
    protected static ?string $pluralModelLabel = 'الطلبات';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الطلب')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('رقم الطلب')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\Select::make('customer_id')
                            ->label('العميل')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->label('حالة الطلب')
                            ->options(collect(OrderStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('حالة الدفع')
                            ->options(collect(PaymentStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\Select::make('payment_method')
                            ->label('طريقة الدفع')
                            ->options(collect(PaymentMethod::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
                        Forms\Components\Select::make('shipping_method_id')
                            ->label('طريقة الشحن')
                            ->relationship('shippingMethod', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('coupon_id')
                            ->label('كوبون الخصم')
                            ->relationship('coupon', 'code')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
                Forms\Components\Section::make('منتجات الطلب')
                    ->schema([
                        Forms\Components\Repeater::make('order_items')
                            ->label('المنتجات')
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->label('المنتج')
                                    ->options(function () {
                                        return \App\Models\Product::where('is_active', true)
                                            ->get()
                                            ->mapWithKeys(fn ($product) => [$product->id => $product->name . ' (' . $product->sku . ')'])
                                            ->toArray();
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                                        if ($state) {
                                            $product = \App\Models\Product::find($state);
                                            if ($product) {
                                                $set('product_name', $product->name);
                                                $set('product_sku', $product->sku);
                                                $set('price', $product->price);
                                                $quantity = $get('quantity') ?: 1;
                                                $set('total', $product->price * $quantity);
                                            }
                                        }
                                    })
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('product_name')
                                    ->label('اسم المنتج')
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\TextInput::make('product_sku')
                                    ->label('رمز المنتج')
                                    ->disabled()
                                    ->dehydrated(),
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
                                    ->prefix('ر.س')
                                    ->step(0.01)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, Forms\Set $set, $get) {
                                        $quantity = $get('quantity') ?: 1;
                                        $set('total', $state * $quantity);
                                    }),
                                Forms\Components\TextInput::make('total')
                                    ->label('الإجمالي')
                                    ->numeric()
                                    ->prefix('ر.س')
                                    ->disabled()
                                    ->dehydrated(),
                            ])
                            ->columns(6)
                            ->defaultItems(1)
                            ->addActionLabel('إضافة منتج')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['product_name'] ?? 'منتج جديد')
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                // حساب المجموع الفرعي من جميع المنتجات
                                $items = $get('order_items') ?? [];
                                $subtotal = 0;
                                foreach ($items as $item) {
                                    if (isset($item['total']) && is_numeric($item['total'])) {
                                        $subtotal += $item['total'];
                                    }
                                }
                                $set('subtotal', $subtotal);
                                
                                // حساب الإجمالي
                                $tax = $get('tax_amount') ?? 0;
                                $shipping = $get('shipping_cost') ?? 0;
                                $discount = $get('discount_amount') ?? 0;
                                $set('total', $subtotal + $tax + $shipping - $discount);
                            })
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
                Forms\Components\Section::make('المبالغ')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->label('المجموع الفرعي')
                            ->numeric()
                            ->prefix('ر.س')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->reactive(),
                        Forms\Components\TextInput::make('tax_amount')
                            ->label('الضريبة')
                            ->numeric()
                            ->prefix('ر.س')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $subtotal = $get('subtotal') ?? 0;
                                $tax = $get('tax_amount') ?? 0;
                                $shipping = $get('shipping_cost') ?? 0;
                                $discount = $get('discount_amount') ?? 0;
                                $set('total', $subtotal + $tax + $shipping - $discount);
                            }),
                        Forms\Components\TextInput::make('shipping_cost')
                            ->label('تكلفة الشحن')
                            ->numeric()
                            ->prefix('ر.س')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $subtotal = $get('subtotal') ?? 0;
                                $tax = $get('tax_amount') ?? 0;
                                $shipping = $get('shipping_cost') ?? 0;
                                $discount = $get('discount_amount') ?? 0;
                                $set('total', $subtotal + $tax + $shipping - $discount);
                            }),
                        Forms\Components\TextInput::make('discount_amount')
                            ->label('مبلغ الخصم')
                            ->numeric()
                            ->prefix('ر.س')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                $subtotal = $get('subtotal') ?? 0;
                                $tax = $get('tax_amount') ?? 0;
                                $shipping = $get('shipping_cost') ?? 0;
                                $discount = $get('discount_amount') ?? 0;
                                $set('total', $subtotal + $tax + $shipping - $discount);
                            }),
                        Forms\Components\TextInput::make('total')
                            ->label('الإجمالي')
                            ->numeric()
                            ->prefix('ر.س')
                            ->required()
                            ->disabled()
                            ->dehydrated()
                            ->reactive(),
                    ])->columns(5),
                Forms\Components\Section::make('العناوين')
                    ->schema([
                        Forms\Components\KeyValue::make('shipping_address')
                            ->label('عنوان الشحن')
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('billing_address')
                            ->label('عنوان الفوترة')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('ملاحظات')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('shipped_at')
                            ->label('تاريخ الشحن'),
                        Forms\Components\DateTimePicker::make('delivered_at')
                            ->label('تاريخ التسليم'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('رقم الطلب')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('حالة الطلب')
                    ->badge()
                    ->color(fn ($record) => $record->status->color()),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('حالة الدفع')
                    ->badge()
                    ->color(fn ($record) => $record->payment_status->color()),
                Tables\Columns\TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('SAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items_count')
                    ->label('عدد العناصر')
                    ->counts('items'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الطلب')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('حالة الدفع')
                    ->options(collect(PaymentStatus::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
                Tables\Filters\SelectFilter::make('customer_id')
                    ->label('العميل')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('طباعة')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->url(fn ($record) => route('orders.print', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getNavigationBadge(): ?string
    {
        // حساب عدد الطلبات التي تحتاج إلى إشعار
        $count = static::getModel()::where(function ($query) {
            $query->where('status', OrderStatus::PENDING->value)
                ->orWhere('payment_status', PaymentStatus::PENDING->value);
        })->count();
        
        return $count > 0 ? (string) $count : null;
    }
    
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger'; // أحمر
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
