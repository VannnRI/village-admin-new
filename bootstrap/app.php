<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'super.admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'admin.desa' => \App\Http\Middleware\AdminDesaMiddleware::class,
            'perangkat.desa' => \App\Http\Middleware\PerangkatDesaMiddleware::class,
            'masyarakat' => \App\Http\Middleware\MasyarakatMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
