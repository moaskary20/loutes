<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static string $view = 'filament.pages.site-settings';
    
    protected static ?string $navigationLabel = 'إعدادات الموقع';
    
    protected static ?string $title = 'إعدادات الموقع';
    
    protected static ?string $navigationGroup = 'الإعدادات';
    
    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::getSettings();
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('صورة خلفية السليدر')
                    ->description('قم برفع صورة خلفية للسليدر أو استخدم اللون الافتراضي')
                    ->schema([
                        Toggle::make('use_background_image')
                            ->label('استخدام صورة خلفية')
                            ->default(false)
                            ->live()
                            ->helperText('قم بتفعيل هذا الخيار لاستخدام صورة خلفية بدلاً من اللون'),
                        
                        FileUpload::make('background_image')
                            ->label('صورة الخلفية')
                            ->image()
                            ->directory('site/background')
                            ->helperText('يُنصح برفع صورة بدقة عالية (1920x1080 أو أكبر)')
                            ->visible(fn ($get) => $get('use_background_image'))
                            ->live()
                            ->afterStateUpdated(function ($state) {
                                // حفظ تلقائي عند رفع الصورة
                                if ($state) {
                                    $this->saveAfterUpload();
                                }
                            })
                            ->columnSpanFull(),
                        
                        ColorPicker::make('background_color')
                            ->label('لون الخلفية الافتراضي')
                            ->default('#cead42')
                            ->helperText('سيتم استخدام هذا اللون إذا لم تكن هناك صورة خلفية')
                            ->visible(fn ($get) => !$get('use_background_image')),
                    ])
                    ->columns(2),
                Section::make('زر View Products')
                    ->description('إعدادات زر "View Products" الذي يظهر تحت صور السليدر')
                    ->schema([
                        TextInput::make('view_products_link')
                            ->label('رابط زر View Products')
                            ->url()
                            ->helperText('أدخل الرابط الذي سيتم الانتقال إليه عند النقر على زر "View Products"')
                            ->placeholder('https://example.com/products')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('حفظ الإعدادات')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        $settings = SiteSetting::getSettings();
        $settings->update($data);
        
        FilamentNotification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }

    protected function saveAfterUpload(): void
    {
        $data = $this->form->getState();
        
        $settings = SiteSetting::getSettings();
        $settings->update([
            'background_image' => $data['background_image'] ?? null,
            'use_background_image' => $data['use_background_image'] ?? false,
        ]);
        
        FilamentNotification::make()
            ->title('تم رفع الصورة بنجاح')
            ->success()
            ->send();
    }
}
