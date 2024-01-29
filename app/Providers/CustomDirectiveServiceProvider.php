<?php

namespace App\Providers;

use App\Helpers\GeneralHelpers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Blade::directive('isActiveRoute', function (string $routeName, string $activeClasses = '', string $deactiveClasses = '') {
        //     return GeneralHelpers::isCurrentRoute($routeName) ? $activeClasses : $deactiveClasses;
        // });

        Blade::if('isActiveRoute', function (string $routeName) {
            return GeneralHelpers::isCurrentRoute($routeName);
        });
    }
}
