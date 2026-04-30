<?php

use App\Http\Middleware\EnsureCompanyRole;
use App\Http\Middleware\EnsureStudentRole;
use App\Http\Middleware\EnsureUniversityAdminRole;
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
        $middleware->alias([
            'company' => EnsureCompanyRole::class,
            'student' => EnsureStudentRole::class,
            'university' => EnsureUniversityAdminRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
