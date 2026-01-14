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

        if (!$user || !$user->canAccessAdmin()) {
            abort(403, 'ليس لديك صلاحية للوصول إلى لوحة التحكم');
        }

        return $next($request);
    }
}
