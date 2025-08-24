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
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function ($command) {
        $command->command('app:rest-your-body --isolated')->timezone(config('app.timezone_indian'))->cron('*/20 * * * *');
        /*$command->command('app:rest-your-body')->hourly()->withoutOverlapping();*/ // No need of --isolated in command argument with this type of use case
    })
    ->create();
