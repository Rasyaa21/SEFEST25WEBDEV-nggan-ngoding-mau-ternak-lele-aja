<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\EncryptCookies;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'createInvoice',
            '/transaction/callback',
        ]);
        $middleware->append(StartSession::class);
        $middleware->trustProxies(at: '*');
        // $middleware->append(EncryptCookies::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        App\Providers\RepositoryServiceProvider::class,
    ])
    ->create();
