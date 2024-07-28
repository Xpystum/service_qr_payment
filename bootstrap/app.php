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
        $middleware->alias([
            'admin/manager_user' => \App\Http\Middleware\User\AdminOrManager::class,
            'admin_user' => \App\Http\Middleware\User\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // $exceptions->render(function (NotFoundHttpException $e, Request $request) {

        //     if ($request->is('api/*')) {

        //         if ($e instanceof ModelNotFoundException) {
        //             return response()->json([
        //                 'message' => 'Resource not found'
        //             ], 404);
        //     }

        //     if ($e instanceof NotFoundHttpException) {
        //         return response()->json([
        //             'message' => 'Page not found'
        //         ], 404);
        //     }

        //     }

        // });

    })->create();


