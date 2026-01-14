<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'الفئات';
    
    protected static ?string $modelLabel = 'فئة';
    
    protected static ?string $pluralModelLabel = 'الفئات';
    
    protected static ?string $navigationGroup = 'إدارة المتجر';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الفئة')
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
                        Forms\Components\Textarea::make('description')
                            ->label('الوصف')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('الصورة')
                            ->image()
                            ->directory('categories')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make('الإعدادات')
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->label('الفئة الرئيسية')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('ترتيب العرض')
                            ->numeric()
                            ->default(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('الفئة الرئيسية')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('عدد المنتجات')
                    ->counts('products'),
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
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('الفئة الرئيسية')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload(),
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
            ->defaultSort('sort_order');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
