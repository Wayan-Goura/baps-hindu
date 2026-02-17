<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Mengatur tujuan redirect secara global di Laravel 11
        $middleware->redirectTo(
            guests: '/login', // Jika belum login dan akses halaman rahasia, lempar ke sini
            users: '/beranda'  // Jika sudah login tapi coba akses halaman login/register, lempar ke sini
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();