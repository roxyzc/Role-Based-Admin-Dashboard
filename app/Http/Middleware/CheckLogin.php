<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')
                ->withErrors(['error' => 'Anda tidak memiliki izin untuk mengakses halaman ini']);
        }

        return $next($request);
    }
}
