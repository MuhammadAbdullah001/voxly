<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\sendFeeNotificationCron'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();


//        $schedule->command('removeReserve:booking')->everyMinute();
        $schedule->command('feeNotification:cron')->daily()->withoutOverlapping();
        // $schedule->command('feeNotification:cron')->dailyAt('20:25');
        //   $schedule->command('feeNotification:cron')->dailyAt('02:45');
                // $schedule->command('feeNotification:cron')->everyMinute();

//        $schedule->command('calculateBill:resident')->monthly();
//        $schedule->command('calculateBill:resident')->everyMinute();
//        $schedule->command('calculateBill:resident')->monthlyOn(5, '21:10');
        // On(26) , '09:30'



    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
