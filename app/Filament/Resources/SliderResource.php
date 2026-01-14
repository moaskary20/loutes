<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Filament\Resources\SliderResource\RelationManagers;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    
    protected static ?string $navigationLabel = 'السليدر';
    
    protected static ?string $modelLabel = 'صورة سليدر';
    
    protected static ?string $pluralModelLabel = 'صور السليدر';
    
    protected static ?string $navigationGroup = 'الإعدادات';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الصورة')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('العنوان')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('الصورة')
                            ->image()
                            ->required()
                            ->directory('sliders')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('link')
                            ->label('الرابط')
                            ->url()
                            ->helperText('رابط عند النقر على الصورة (اختياري)')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->default(0)
                            ->helperText('كلما قل الرقم، كلما ظهرت الصورة أولاً'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->circular()
                    ->size(80),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('sort_order', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
