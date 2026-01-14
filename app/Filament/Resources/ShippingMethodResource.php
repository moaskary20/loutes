<?php

namespace App\Filament\Resources;

use App\Enums\ShippingType;
use App\Filament\Resources\ShippingMethodResource\Pages;
use App\Models\Province;
use App\Models\ShippingMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShippingMethodResource extends Resource
{
    protected static ?string $model = ShippingMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationLabel = 'طرق الشحن';
    
    protected static ?string $modelLabel = 'طريقة شحن';
    
    protected static ?string $pluralModelLabel = 'طرق الشحن';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات طريقة الشحن')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم (عربي)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_en')
                            ->label('الاسم (إنجليزي)')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->label('النوع')
                            ->options(collect(ShippingType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->required(),
                        Forms\Components\TextInput::make('cost')
                            ->label('التكلفة')
                            ->numeric()
                            ->prefix('ج.م')
                            ->default(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('free_shipping_threshold')
                            ->label('حد الشحن المجاني')
                            ->numeric()
                            ->prefix('ج.م')
                            ->step(0.01),
                        Forms\Components\TextInput::make('estimated_days')
                            ->label('الأيام المتوقعة')
                            ->numeric(),
                    ])->columns(2),
                Forms\Components\Section::make('تكاليف الشحن حسب المحافظة')
                    ->description('حدد تكلفة الشحن لكل محافظة. إذا لم تحدد محافظة، سيتم استخدام التكلفة الافتراضية.')
                    ->schema([
                        Forms\Components\Repeater::make('province_costs')
                            ->label('المحافظات')
                            ->schema([
                                Forms\Components\Select::make('province_id')
                                    ->label('المحافظة')
                                    ->options(Province::where('is_active', true)->orderBy('sort_order')->get()->mapWithKeys(fn($province) => [$province->id => $province->name]))
                                    ->searchable()
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn (Forms\Set $set) => $set('cost', 0))
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('cost')
                                    ->label('التكلفة')
                                    ->numeric()
                                    ->prefix('ج.م')
                                    ->default(0)
                                    ->step(0.01)
                                    ->required()
                                    ->columnSpan(1),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => Province::find($state['province_id'] ?? null)?->name ?? 'محافظة جديدة')
                            ->collapsible()
                            ->defaultItems(0)
                            ->addActionLabel('إضافة محافظة')
                            ->reorderableWithButtons()
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('التكلفة')
                    ->money('EGP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('free_shipping_threshold')
                    ->label('حد الشحن المجاني')
                    ->money('EGP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estimated_days')
                    ->label('الأيام المتوقعة')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('نشط'),
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
            ->defaultSort('name');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShippingMethods::route('/'),
            'create' => Pages\CreateShippingMethod::route('/create'),
            'edit' => Pages\EditShippingMethod::route('/{record}/edit'),
        ];
    }
}
