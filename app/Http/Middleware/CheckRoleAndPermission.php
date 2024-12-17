<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleAndPermission
{
    public function handle(Request $request, Closure $next, ...$rolesAndPermissions)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Akses ditolak.');
        }

        $hasRole = false;
        $hasPermission = false;

        foreach ($rolesAndPermissions as $value) {
            if ($value === 'admin' || $user->role->role_name === $value) {
                $hasRole = true;
            }

            if (str_starts_with($value, 'permission:')) {
                $permissionName = str_replace('permission:', '', $value);
                if ($user->role->permissions->contains('name', $permissionName)) {
                    $hasPermission = true;
                }
            }
        }

        if ($hasRole || $hasPermission) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses.');
    }
}
