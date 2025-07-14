<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerangkatDesaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isPerangkatDesa()) {
            return redirect()->route('login')->with('error', 'Akses ditolak. Anda harus login sebagai Perangkat Desa.');
        }

        return $next($request);
    }
} 