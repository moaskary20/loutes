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

        if (!$user) {
            abort(403, 'ليس لديك صلاحية للوصول إلى لوحة التحكم');
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
