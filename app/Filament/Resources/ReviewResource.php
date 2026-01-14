<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    protected static ?string $navigationLabel = 'التقييمات';
    
    protected static ?string $modelLabel = 'تقييم';
    
    protected static ?string $pluralModelLabel = 'التقييمات';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('المنتج')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->label('العميل')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('order_id')
                    ->label('الطلب')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('rating')
                    ->label('التقييم')
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->label('العنوان')
                    ->maxLength(255),
                Forms\Components\Textarea::make('comment')
                    ->label('التعليق')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_approved')
                    ->label('موافق عليه')
                    ->default(false),
                Forms\Components\Toggle::make('is_featured')
                    ->label('مميز'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('التقييم')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state))
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('موافق عليه')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('مميز')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('موافق عليه'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('مميز'),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('التقييم')
                    ->options([
                        1 => '⭐',
                        2 => '⭐⭐',
                        3 => '⭐⭐⭐',
                        4 => '⭐⭐⭐⭐',
                        5 => '⭐⭐⭐⭐⭐',
                    ]),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
