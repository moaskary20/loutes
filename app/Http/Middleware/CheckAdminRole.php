<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // هذا middleware يعمل فقط بعد Authenticate middleware
        // لذا المستخدم يجب أن يكون مسجل دخول بالفعل
        if (!$user) {
            return redirect()->route('filament.admin.auth.login');
        }

        // إذا كان role غير محدد (null)، افترض أنه admin (للمستخدمين القدامى)
        if ($user->role === null) {
            $user->role = UserRole::Admin;
            $user->save();
        }

        if (!$user->canAccessAdmin()) {
            abort(403, 'ليس لديك صلاحية للوصول إلى لوحة التحكم');
        }

        return $next($request);
    }
}
