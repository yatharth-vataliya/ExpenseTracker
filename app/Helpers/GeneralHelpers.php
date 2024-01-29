<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Request;

class GeneralHelpers
{
    public static function isCurrentRoute(string $routeName): bool
    {
        return Request::is($routeName);
    }
}
