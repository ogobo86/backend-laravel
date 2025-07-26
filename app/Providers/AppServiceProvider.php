<?php

namespace App\Providers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\Services\HiService;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Implementacion de interfas
        $this -> app ->bind(MessageServiceInterface::class, HiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
