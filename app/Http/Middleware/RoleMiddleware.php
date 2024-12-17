<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array(Auth::user()->role->role_name, $roles)) {
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengakses halaman ini']);
        }

        return $next($request);
    }
}
