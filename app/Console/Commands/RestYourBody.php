<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;

class RestYourBody extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rest-your-body';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $env = config('app.env');
        $isHealthReminder = config('app.health_reminder');
        if ($env === 'local' && $isHealthReminder) {
            Log::channel('daily')->info('Taking action for your body is good now! '.$env.now()->tz(config('app.timezone_indian')));

            $proccess = Process::path(public_path('/CustomAssests/images/'))
                ->command('export DISPLAY=:0.0 && xdg-open hourly-health-reminder.gif')
                ->run();

            Log::channel('daily')->info(
                $proccess->failed() ?
                    "Something bad with the system please try again later {$proccess->errorOutput()}"
                    : $proccess->output());

            Log::channel('daily')->info('You are all set now '.$env.now()->tz(config('app.timezone_indian')));

        }
    }
}
