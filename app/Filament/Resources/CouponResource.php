<?php

namespace App\Filament\Resources;

use App\Enums\CouponType;
use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    
    protected static ?string $navigationLabel = 'الكوبونات';
    
    protected static ?string $modelLabel = 'كوبون';
    
    protected static ?string $pluralModelLabel = 'الكوبونات';
    
    protected static ?string $navigationGroup = 'إدارة الخصومات';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الكوبون')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('رمز الكوبون')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('النوع')
                            ->options(collect(CouponType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\TextInput::make('value')
                            ->label('القيمة')
                            ->numeric()
                            ->required()
                            ->step(0.01),
                        Forms\Components\TextInput::make('minimum_purchase')
                            ->label('الحد الأدنى للشراء')
                            ->numeric()
                            ->prefix('ر.س')
                            ->step(0.01),
                        Forms\Components\TextInput::make('maximum_discount')
                            ->label('الحد الأقصى للخصم')
                            ->numeric()
                            ->prefix('ر.س')
                            ->step(0.01),
                        Forms\Components\TextInput::make('usage_limit')
                            ->label('حد الاستخدام')
                            ->numeric(),
                        Forms\Components\TextInput::make('used_count')
                            ->label('عدد الاستخدامات')
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                    ])->columns(2),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        Forms\Components\DateTimePicker::make('starts_at')
                            ->label('تاريخ البدء'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('تاريخ الانتهاء'),
                        Forms\Components\Select::make('applicable_to')
                            ->label('ينطبق على')
                            ->options([
                                'all' => 'الكل',
                                'categories' => 'فئات محددة',
                                'products' => 'منتجات محددة',
                            ])
                            ->default('all'),
                    ])->columns(2),
                Forms\Components\Section::make('الفئات والمنتجات')
                    ->schema([
                        Forms\Components\Select::make('categories')
                            ->label('الفئات')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('applicable_to') === 'categories'),
                        Forms\Components\Select::make('products')
                            ->label('المنتجات')
                            ->relationship('products', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->visible(fn ($get) => $get('applicable_to') === 'products'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('رمز الكوبون')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('value')
                    ->label('القيمة')
                    ->formatStateUsing(fn ($record) => $record->type === CouponType::PERCENTAGE ? $record->value . '%' : $record->value . ' ر.س'),
                Tables\Columns\TextColumn::make('used_count')
                    ->label('عدد الاستخدامات')
                    ->sortable(),
                Tables\Columns\TextColumn::make('usage_limit')
                    ->label('حد الاستخدام')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('تاريخ الانتهاء')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('نشط'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('النوع')
                    ->options(collect(CouponType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
