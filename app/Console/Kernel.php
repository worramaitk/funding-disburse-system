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
        // Linux report memory statistics to the pseudo filesystem /proc/meminfo. https://www.howtogeek.com/659529/how-to-check-memory-usage-from-the-linux-terminal/
        //technically speaking I could also use printf instead of echo https://stackoverflow.com/questions/8467424/echo-newline-in-bash-prints-literal-n
        ->exec('cur=$(date) mem=$(cat /proc/meminfo); echo "\nCurrent date and time: $cur\nCurrent memory usage:\n$mem"')
        ->everyMinute()
        ->appendOutputTo("storage/logs/".date("Y-m-d",time()).".log");
        // replace above line with ‘->sendOutputTo("scheduler-output.log");’ if you wish to overwrite the whole file.
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
