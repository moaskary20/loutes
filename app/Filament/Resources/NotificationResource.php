<?php

namespace App\Filament\Resources;

use App\Enums\NotificationType;
use App\Filament\Resources\NotificationResource\Pages;
use App\Filament\Resources\NotificationResource\RelationManagers;
use App\Models\Notification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    
    protected static ?string $navigationLabel = 'الإشعارات';
    
    protected static ?string $modelLabel = 'إشعار';
    
    protected static ?string $pluralModelLabel = 'الإشعارات';
    
    protected static ?string $navigationGroup = 'الإدارة';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الإشعار')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('نوع الإشعار')
                            ->options(collect(NotificationType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('title')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->label('الرسالة')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('target_type')
                            ->label('نوع المستهدف')
                            ->options([
                                'admin' => 'مدير',
                                'customer' => 'عميل',
                                'all' => 'الكل',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('target_id')
                            ->label('معرف المستهدف')
                            ->numeric()
                            ->helperText('معرف المستخدم أو العميل (اتركه فارغاً للكل)'),
                        Forms\Components\Select::make('related_type')
                            ->label('نوع المرتبط')
                            ->options([
                                'order' => 'طلب',
                                'product' => 'منتج',
                                'coupon' => 'كوبون',
                                'customer' => 'عميل',
                            ])
                            ->native(false),
                        Forms\Components\TextInput::make('related_id')
                            ->label('معرف المرتبط')
                            ->numeric()
                            ->helperText('معرف الطلب أو المنتج أو الكوبون المرتبط'),
                        Forms\Components\Toggle::make('is_read')
                            ->label('مقروء')
                            ->default(false),
                        Forms\Components\KeyValue::make('data')
                            ->label('بيانات إضافية')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('مقروء')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn (NotificationType $state): string => $state->label())
                    ->color(fn (NotificationType $state): string => $state->color())
                    ->icon(fn (NotificationType $state): string => $state->icon())
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('message')
                    ->label('الرسالة')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('target_type')
                    ->label('المستهدف')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'admin' => 'مدير',
                        'customer' => 'عميل',
                        'all' => 'الكل',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match($state) {
                        'admin' => 'danger',
                        'customer' => 'info',
                        'all' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('مقروء')
                    ->placeholder('الكل')
                    ->trueLabel('مقروء فقط')
                    ->falseLabel('غير مقروء فقط'),
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع الإشعار')
                    ->options(collect(NotificationType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
                Tables\Filters\SelectFilter::make('target_type')
                    ->label('المستهدف')
                    ->options([
                        'admin' => 'مدير',
                        'customer' => 'عميل',
                        'all' => 'الكل',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_read')
                    ->label('تعليم كمقروء')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Notification $record) => !$record->is_read)
                    ->action(fn (Notification $record) => $record->markAsRead())
                    ->requiresConfirmation(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_read')
                        ->label('تعليم كمقروء')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(fn ($records) => $records->each->markAsRead())
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListNotifications::route('/'),
            'create' => Pages\CreateNotification::route('/create'),
            'edit' => Pages\EditNotification::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->forAdmin();
    }
}
