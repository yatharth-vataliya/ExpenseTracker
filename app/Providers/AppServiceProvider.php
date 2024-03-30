<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict();

        $this->bootMacros();
    }

    private function bootMacros()
    {
        Component::macro('toaster', function (string $type = 'info', string $text = 'Hey !') {
            $this->js(<<<JS
            showToaster('$type', '$text');
        JS);
        });

        Carbon::macro('timeZoneIndian', function () {
            return $this->tz(config('app.timezone_indian'));
        });
    }
}
