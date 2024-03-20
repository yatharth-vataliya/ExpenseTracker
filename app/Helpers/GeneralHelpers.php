<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class GeneralHelpers
{
    public static function isCurrentRoute(string $routeName): bool
    {
        return Route::currentRouteName() === $routeName;
    }
}
