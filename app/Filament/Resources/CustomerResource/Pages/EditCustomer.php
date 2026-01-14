<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $customer = $this->record;
        
        // إذا كان هناك حساب مستخدم مرتبط
        if ($customer->user_id) {
            $user = $customer->user;
            
            // تحديث الصلاحيات إذا تم تغييرها
            if (isset($data['user_role']) && $data['user_role'] !== $user->role->value) {
                $user->role = UserRole::from($data['user_role']);
                $user->save();
            }
            
            // تحديث كلمة المرور إذا تم إدخال كلمة مرور جديدة
            if (isset($data['user_password']) && filled($data['user_password'])) {
                $user->password = Hash::make($data['user_password']);
                $user->save();
            }
        }
        
        // إزالة الحقول المؤقتة
        unset($data['user_role'], $data['user_password'], $data['user_password_confirmation']);
        
        return $data;
    }
}
