<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'check.active' => \App\Http\Middleware\CheckUserStatus::class,
        ]);

        // Add this line to exclude your route from CSRF
        $middleware->validateCsrfTokens(except: [
            'apply/submit'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
