<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        //web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'user','user/*',
            'contract','contract/*',
            'point','point/*',
            'login','login/*',
            'logout','logout/*',
            'consulttoken', 'consulttoken/*'
        ]);

        $middleware->use([\Illuminate\Http\Middleware\HandleCors::class]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
