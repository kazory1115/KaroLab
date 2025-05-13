<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 設定排除Csrf 的路由
        $middleware->validateCsrfTokens(except: [
            'api/*', // 禁用對 API 路由的 CSRF 驗證

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
