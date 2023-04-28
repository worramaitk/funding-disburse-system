<?php

namespace App\Console;

use App\Http\Controllers\LogController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule
        ->exec('current_time=$(date) ; echo "Current date and time: $current_time"')
        ->everyMinute()
        ->appendOutputTo("scheduler-output.log");
        // replace above line with ‘->sendOutputTo("scheduler-output.log");’ instead if you wish to overwrite the whole file.
        //example code from https://laravel.com/docs/10.x/scheduling#scheduling-shell-commands
        //and https://www.howtogeek.com/410442/how-to-display-the-date-and-time-in-the-linux-terminal-and-use-it-in-bash-scripts/
        // $schedule->exec('date')->everyMinute();

        // $schedule->call(function () {
        //     LogController::logging('a minute had passed');
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
