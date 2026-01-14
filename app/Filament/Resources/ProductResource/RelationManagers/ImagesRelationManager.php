<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'صور المنتج';

    protected static ?string $modelLabel = 'صورة';

    protected static ?string $pluralModelLabel = 'الصور';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->directory('products')
                    ->required()
                    ->imageEditor()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_primary')
                    ->label('صورة أساسية')
                    ->helperText('الصورة الأساسية ستظهر كصورة رئيسية للمنتج')
                    ->default(false),
                Forms\Components\TextInput::make('sort_order')
                    ->label('ترتيب العرض')
                    ->numeric()
                    ->default(0)
                    ->helperText('رقم أقل يعني ظهور الصورة أولاً'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة')
                    ->circular()
                    ->size(80),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('صورة أساسية')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_primary')
                    ->label('صورة أساسية')
                    ->placeholder('الكل')
                    ->trueLabel('أساسية فقط')
                    ->falseLabel('غير أساسية'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة صورة'),
            ])
            ->actions([
                Tables\Actions\Action::make('set_primary')
                    ->label('تعيين كأساسية')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn ($record) => !$record->is_primary)
                    ->action(function ($record) {
                        // إلغاء تحديد الصور الأخرى كأساسية
                        $record->product->images()->where('id', '!=', $record->id)->update(['is_primary' => false]);
                        // تعيين هذه الصورة كأساسية
                        $record->update(['is_primary' => true]);
                    })
                    ->requiresConfirmation()
                    ->successNotificationTitle('تم تعيين الصورة كأساسية'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }
}
