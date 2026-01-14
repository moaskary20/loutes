<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Enums\UserRole;
use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // إذا كان المستخدم يريد إنشاء حساب مستخدم
        if (isset($data['create_user_account']) && $data['create_user_account']) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['user_password']),
                'role' => UserRole::from($data['user_role'] ?? UserRole::Customer->value),
            ]);
            
            $data['user_id'] = $user->id;
        }

        // إزالة الحقول المؤقتة
        unset($data['create_user_account'], $data['user_role'], $data['user_password'], $data['user_password_confirmation']);

        return $data;
    }
}
