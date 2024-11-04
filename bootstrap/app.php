<?php

use App\Http\Middleware\CheckUserPermissions as MiddlewareCheckUserPermissions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Modules\AuthModule\Http\Middleware\CheckUserPermissions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->redirectGuestsTo('myadmin/login');

        $middleware->alias([
            'checkPermission' => CheckUserPermissions::class,
            'checkRole' => MiddlewareCheckUserPermissions::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->register();
    })->create();
