<?php

namespace App\Filament\Widgets;

use App\Models\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class NotificationsWidget extends BaseWidget
{
    protected static ?string $heading = 'الإشعارات الأخيرة';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Notification::query()
                    ->forAdmin()
                    ->unread()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->label('مقروء')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('النوع')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->color(fn ($state) => $state->color())
                    ->icon(fn ($state) => $state->icon())
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('العنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('message')
                    ->label('الرسالة')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_read')
                    ->label('تعليم كمقروء')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (Notification $record) => $record->markAsRead())
                    ->requiresConfirmation(false),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('لا توجد إشعارات جديدة')
            ->emptyStateDescription('ستظهر الإشعارات الجديدة هنا');
    }
}
