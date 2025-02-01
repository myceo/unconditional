<?php

namespace App\Console;

use App\Lib\CronJobs;
use App\LibSaas\CronJobsSaas;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


        if(isSaas()){
            $schedule->call(function () {
                $cronJobs = new CronJobsSaas();
                try{
                    $cronJobs->siteCron();
                }
                catch(\Exception $ex){
                }
            })->dailyAt('11:00');


            $schedule->call(function () {
                $cronJobs = new CronJobsSaas();
                try{
                    $cronJobs->notifyExpiringUsers();
                }
                catch(\Exception $ex){
                }
            })->dailyAt('13:00');
        }

        if(isTenant()){
            setTenantDb();
            $schedule->call(function () {
                $cronJobs = new CronJobs();
                $cronJobs->deleteTempFiles();
                $cronJobs->upcomingEvents();
            })->daily();
        }

        // $schedule->command('inspire')
        //          ->hourly();
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
