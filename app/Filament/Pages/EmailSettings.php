<?php

namespace App\Filament\Pages;

use App\Enums\NotificationType;
use App\Models\EmailSetting;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Mail;

class EmailSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    
    protected static string $view = 'filament.pages.email-settings';
    
    protected static ?string $navigationLabel = 'إعدادات البريد الإلكتروني';
    
    protected static ?string $title = 'إعدادات البريد الإلكتروني';
    
    protected static ?string $navigationGroup = 'الإعدادات';
    
    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $settings = EmailSetting::getSettings();
        $data = $settings->toArray();
        
        // تعيين قيم افتراضية للحقول الفارغة
        $data['from_name'] = $data['from_name'] ?? 'Loutes Store';
        $data['send_notifications'] = $data['send_notifications'] ?? true;
        $data['enabled'] = $data['enabled'] ?? false;
        $data['notification_types'] = $data['notification_types'] ?? [];
        
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('إعدادات Brevo')
                    ->description('قم بإدخال بيانات Brevo لإرسال الإشعارات عبر البريد الإلكتروني')
                    ->schema([
                        TextInput::make('brevo_api_key')
                            ->label('Brevo API Key')
                            ->password()
                            ->rules(['required', 'string'])
                            ->validationMessages([
                                'required' => 'حقل Brevo API Key مطلوب',
                            ])
                            ->helperText('يمكنك الحصول على API Key من حساب Brevo الخاص بك')
                            ->columnSpanFull(),
                        
                        TextInput::make('from_email')
                            ->label('البريد الإلكتروني المرسل')
                            ->email()
                            ->rules(['required', 'email'])
                            ->validationMessages([
                                'required' => 'حقل البريد الإلكتروني المرسل مطلوب',
                                'email' => 'البريد الإلكتروني المرسل يجب أن يكون بريداً إلكترونياً صحيحاً',
                            ])
                            ->helperText('البريد الإلكتروني الذي سيظهر كمرسل')
                            ->columnSpan(1),
                        
                        TextInput::make('from_name')
                            ->label('اسم المرسل')
                            ->default('Loutes Store')
                            ->rules(['required', 'string'])
                            ->validationMessages([
                                'required' => 'حقل اسم المرسل مطلوب',
                            ])
                            ->helperText('الاسم الذي سيظهر كمرسل')
                            ->columnSpan(1),
                        
                        TextInput::make('admin_email')
                            ->label('البريد الإلكتروني المستلم')
                            ->email()
                            ->rules(['required', 'email'])
                            ->validationMessages([
                                'required' => 'حقل البريد الإلكتروني المستلم مطلوب',
                                'email' => 'البريد الإلكتروني المستلم يجب أن يكون بريداً إلكترونياً صحيحاً',
                            ])
                            ->helperText('البريد الإلكتروني الذي سيستقبل جميع الإشعارات')
                            ->columnSpanFull(),
                        
                        Toggle::make('enabled')
                            ->label('تفعيل إرسال البريد الإلكتروني')
                            ->default(false)
                            ->helperText('قم بتفعيل هذا الخيار بعد إدخال جميع البيانات لتفعيل إرسال الإشعارات عبر البريد الإلكتروني')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Section::make('إعدادات الإشعارات')
                    ->description('اختر أنواع الإشعارات التي تريد إرسالها عبر البريد الإلكتروني')
                    ->schema([
                        Toggle::make('send_notifications')
                            ->label('إرسال الإشعارات عبر البريد')
                            ->default(true)
                            ->live()
                            ->helperText('إرسال جميع الإشعارات عبر البريد الإلكتروني'),
                        
                        CheckboxList::make('notification_types')
                            ->label('أنواع الإشعارات المراد إرسالها')
                            ->options(collect(NotificationType::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()]))
                            ->helperText('اختر أنواع الإشعارات التي تريد إرسالها عبر البريد (اتركه فارغاً لإرسال جميع الأنواع)')
                            ->visible(fn ($get) => $get('send_notifications'))
                            ->columns(2),
                    ]),
                
                Section::make('اختبار الإعدادات')
                    ->description('قم بإرسال بريد تجريبي للتحقق من صحة الإعدادات')
                    ->schema([
                        Forms\Components\Placeholder::make('test_email_info')
                            ->label('')
                            ->content('بعد إدخال البيانات وحفظ الإعدادات، يمكنك استخدام زر "إرسال بريد تجريبي" في أعلى الصفحة للتحقق من صحة الإعدادات'),
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
            Action::make('test_email')
                ->label('إرسال بريد تجريبي')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function () {
                    try {
                        $data = $this->form->getState();
                        $this->sendTestEmail($data);
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        FilamentNotification::make()
                            ->title('خطأ في البيانات')
                            ->body('يرجى إدخال جميع البيانات المطلوبة قبل إرسال البريد التجريبي')
                            ->danger()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->visible(function () {
                    $data = $this->data ?? [];
                    return !empty($data['brevo_api_key'] ?? '') && !empty($data['admin_email'] ?? '');
                }),
        ];
    }

    public function save(): void
    {
        // التحقق من البيانات قبل الحفظ
        $this->form->validate();
        
        $data = $this->form->getState();
        
        $settings = EmailSetting::getSettings();
        $settings->update($data);
        
        // تحديث إعدادات Laravel Mail
        $this->updateMailConfig($settings);
        
        FilamentNotification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }

    protected function sendTestEmail(array $data): void
    {
        try {
            if (empty($data['admin_email']) || empty($data['brevo_api_key'])) {
                throw new \Exception('يرجى إدخال جميع البيانات المطلوبة');
            }

            // تحديث إعدادات Mail مؤقتاً
            config([
                'mail.mailers.brevo' => [
                    'transport' => 'brevo',
                    'api_key' => $data['brevo_api_key'],
                ],
                'mail.from' => [
                    'address' => $data['from_email'] ?? 'noreply@loutes.com',
                    'name' => $data['from_name'] ?? 'Loutes Store',
                ],
            ]);

            Mail::raw('هذا بريد تجريبي من نظام Loutes Store. إذا وصلت هذا البريد، فالإعدادات تعمل بشكل صحيح.', function ($message) use ($data) {
                $message->to($data['admin_email'])
                    ->subject('بريد تجريبي - Loutes Store');
            });

            FilamentNotification::make()
                ->title('تم إرسال البريد التجريبي بنجاح')
                ->body('يرجى التحقق من صندوق الوارد للبريد الإلكتروني: ' . $data['admin_email'])
                ->success()
                ->send();
        } catch (\Exception $e) {
            FilamentNotification::make()
                ->title('فشل إرسال البريد التجريبي')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function updateMailConfig(EmailSetting $settings): void
    {
        if ($settings->isEnabled()) {
            // تحديث إعدادات Mail في config
            config([
                'mail.default' => 'brevo',
                'mail.mailers.brevo' => [
                    'transport' => 'brevo',
                    'api_key' => $settings->brevo_api_key,
                ],
                'mail.from' => [
                    'address' => $settings->from_email,
                    'name' => $settings->from_name,
                ],
            ]);
        }
    }
}
