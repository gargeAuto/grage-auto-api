<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\PurgeUnverifiedUsers;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     */
    protected $commands = [
        // Enregistre ici ta commande artisan personnalisée
        PurgeUnverifiedUsers::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Planifie la commande toutes les 5 minutes pour test
         $schedule->command('app:purge-unverified-users')->everyMinute()->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Charge automatiquement les commandes artisan dans routes/console.php
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
