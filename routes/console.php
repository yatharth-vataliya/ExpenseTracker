<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('battery-alert', function () {
    $result = Process::pipe([
        'upower --dump',
        'grep percentage',
        'head -n 1',
    ]);
    if ($result->successful()) {
        $rawOutput = $result->output();
        $batteryPercentage = explode(':', $rawOutput)[1];
        $batteryPercentage = (int) trim(trim($batteryPercentage), '%');
        if ($batteryPercentage === 80) {
            $env = config('app.env');
            if ($env === 'local') {
                Process::path(public_path('/CustomAssests/images/'))
                    ->command('export DISPLAY=:0.0 && xdg-open battery-80-percent-alert.png')
                    ->run();

            }
        }
    }
    if ($result->failed()) {
        Log::channel('daily')->error(
            'Time :- '.now(tz: config('app.timezone_indian').' There is a problem running `battery-alert` command and the issue is '.$result->errorOutput())
        );
    }
})->purpose('Alert user if batter is 80% charged.');

Schedule::command('battery-alert')->everyMinute()->timezone(config('app.timezone_indian'));
