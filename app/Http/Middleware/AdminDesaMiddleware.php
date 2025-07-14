<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDesaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isAdminDesa()) {
            return redirect()->route('login')->with('error', 'Akses ditolak. Anda harus login sebagai Admin Desa.');
        }

        return $next($request);
    }
} 