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
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Illuminate\Contracts\Encryption\DecryptException $e, Illuminate\Http\Request $request) {
            $cookieName = config('session.cookie');
            return redirect()->to($request->fullUrl())->withoutCookie($cookieName);
        });

        $exceptions->render(function (Illuminate\Session\TokenMismatchException $e, Illuminate\Http\Request $request) {
            $request->session()->regenerateToken();
            return redirect()->back()->with('error', 'Sesi kedaluwarsa, silakan coba lagi.');
        });
    })->create();
