<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $e, Request $request) {
            return response()->json([
                'message' => $e->getMessage(),
                'timestamp' => now(),
                'code' => method_exists($e, $e->getStatusCode()) ? $e->getStatusCode() : 500,
            ], method_exists($e, $e->getStatusCode()) ? $e->getStatusCode() : 500);
        });
    })->create();
