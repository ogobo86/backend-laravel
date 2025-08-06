<?php

use App\Http\Middleware\CheckValueInHeader;
use App\Http\Middleware\UppercaseName;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Se da de alta
        //$middleware->append(CheckValueInHeader::class);
        $middleware->alias([
            "checkvalue" => CheckValueInHeader::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Programando una Scheduling
    })->withSchedule(function(Schedule $schedule){
        $schedule->command("app:clear-old-upload")->everyMinute();
    })
    ->create();
