<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserRole extends Command
{
    protected $signature = 'users:update-role {email} {role=admin}';

    protected $description = 'تحديث role لمستخدم محدد';

    public function handle()
    {
        $email = $this->argument('email');
        $roleValue = $this->argument('role');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("المستخدم {$email} غير موجود.");
            return Command::FAILURE;
        }

        try {
            $role = UserRole::from($roleValue);
        } catch (\ValueError $e) {
            $this->error("Role غير صحيح. القيم المتاحة: admin, supervisor, customer");
            return Command::FAILURE;
        }

        $user->role = $role;
        $user->save();

        $this->info("تم تحديث role للمستخدم {$email} إلى {$role->label()} ({$role->value})");
        
        return Command::SUCCESS;
    }
}
