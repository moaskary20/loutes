<?php

namespace App\Filament\Resources;

use App\Enums\UserRole;
use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'العملاء';
    
    protected static ?string $modelLabel = 'عميل';
    
    protected static ?string $pluralModelLabel = 'العملاء';

    protected static ?string $navigationGroup = 'إدارة المستخدمين';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات العميل')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('الهاتف')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),
                Forms\Components\Section::make('حساب المستخدم')
                    ->schema([
                        Forms\Components\Toggle::make('create_user_account')
                            ->label('إنشاء حساب مستخدم')
                            ->default(fn ($record) => $record?->user_id ? true : true)
                            ->live()
                            ->helperText('قم بتفعيل هذا الخيار لإنشاء حساب مستخدم مرتبط بهذا العميل')
                            ->visible(fn ($operation) => $operation === 'create')
                            ->columnSpanFull(),
                        Forms\Components\Select::make('user_role')
                            ->label('نوع المستخدم / الصلاحيات')
                            ->options(UserRole::options())
                            ->default(fn ($record) => $record?->user?->role?->value ?? UserRole::Customer->value)
                            ->required(fn (Forms\Get $get, $record) => $get('create_user_account') || $record?->user_id)
                            ->visible(fn (Forms\Get $get, $record, $operation) => 
                                ($operation === 'create' && $get('create_user_account')) || 
                                ($operation === 'edit' && $record?->user_id)
                            )
                            ->helperText('اختر نوع المستخدم وصلاحياته')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('user_password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required(fn (Forms\Get $get, $record, $operation) => 
                                ($operation === 'create' && $get('create_user_account'))
                            )
                            ->minLength(8)
                            ->visible(fn (Forms\Get $get, $record, $operation) => 
                                ($operation === 'create' && $get('create_user_account')) || 
                                ($operation === 'edit' && $record?->user_id)
                            )
                            ->helperText(fn ($operation) => 
                                $operation === 'edit' 
                                    ? 'اتركه فارغاً إذا كنت لا تريد تغيير كلمة المرور' 
                                    : 'يجب أن تكون كلمة المرور 8 أحرف على الأقل'
                            )
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('user_password_confirmation')
                            ->label('تأكيد كلمة المرور')
                            ->password()
                            ->required(fn (Forms\Get $get, $record, $operation) => 
                                ($operation === 'create' && $get('create_user_account')) ||
                                ($operation === 'edit' && filled($get('user_password')))
                            )
                            ->same('user_password')
                            ->visible(fn (Forms\Get $get, $record, $operation) => 
                                ($operation === 'create' && $get('create_user_account')) || 
                                ($operation === 'edit' && $record?->user_id)
                            )
                            ->helperText('أعد إدخال كلمة المرور للتأكيد')
                            ->columnSpan(1),
                        Forms\Components\Select::make('user_id')
                            ->label('ربط بحساب مستخدم موجود')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (Forms\Get $get, $operation) => 
                                $operation === 'create' && !$get('create_user_account')
                            )
                            ->helperText('اختر حساب مستخدم موجود بدلاً من إنشاء حساب جديد')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('العنوان')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->label('العنوان')
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('city')
                            ->label('المدينة')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('الدولة')
                            ->default('السعودية')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('postal_code')
                            ->label('الرمز البريدي')
                            ->maxLength(255),
                    ])->columns(3),
                Forms\Components\Section::make('معلومات إضافية')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('تاريخ الميلاد'),
                        Forms\Components\Select::make('gender')
                            ->label('الجنس')
                            ->options([
                                'male' => 'ذكر',
                                'female' => 'أنثى',
                            ]),
                        Forms\Components\Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true),
                    ])->columns(3),
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
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('الهاتف')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.role')
                    ->label('نوع المستخدم')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        if (!$state) {
                            return 'بدون حساب';
                        }
                        // $state is already a UserRole enum object due to cast in User model
                        if ($state instanceof UserRole) {
                            return $state->label();
                        }
                        // Fallback: if it's a string, convert it
                        return UserRole::from($state)->label();
                    })
                    ->color(function ($state) {
                        if (!$state) {
                            return 'gray';
                        }
                        // Get the value if it's an enum object
                        $value = $state instanceof UserRole ? $state->value : $state;
                        return match($value) {
                            'admin' => 'danger',
                            'supervisor' => 'warning',
                            'customer' => 'success',
                            default => 'gray',
                        };
                    })
                    ->placeholder('بدون حساب'),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('عدد الطلبات')
                    ->counts('orders'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
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
                Tables\Filters\SelectFilter::make('gender')
                    ->label('الجنس')
                    ->options([
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                    ]),
                Tables\Filters\SelectFilter::make('user.role')
                    ->label('نوع المستخدم')
                    ->options(UserRole::options())
                    ->query(function (Builder $query, array $data): Builder {
                        if (!isset($data['value'])) {
                            return $query;
                        }
                        return $query->whereHas('user', function ($q) use ($data) {
                            $q->where('role', $data['value']);
                        });
                    }),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
