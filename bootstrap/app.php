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
        // Daftarkan alias middleware kustom kamu di sini
        $middleware->alias([
            'admin.auth'    => \App\Http\Middleware\AdminMiddleware::class,
            'customer.auth' => \App\Http\Middleware\CustomerMiddleware::class,
        ]);

        // Kalau nanti kamu punya middleware global, bisa daftarkan seperti ini:
        // $middleware->web([
        //     \App\Http\Middleware\YourGlobalMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Bisa tambahkan custom exception handler di sini kalau mau
        // Contoh:
        // $exceptions->report(function (Throwable $e) {
        //     // custom log/report logic
        // });
    })
    ->create();
