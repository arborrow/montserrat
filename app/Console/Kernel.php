<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('mailgun:get')->hourlyAt(55)
            ->between('05:30', '18:30')
            ->emailOutputOnFailure(config('polanco.admin_email'));
        $schedule->command('import:stripe_payouts')->dailyAt('08:00')->emailOutputOnFailure(config('polanco.admin_email'));
        $schedule->command('email:birthdays')->dailyAt('06:00')->emailOutputOnFailure(config('polanco.admin_email'));
        $schedule->command('email:confirmations')->dailyAt('07:00')->emailOutputOnFailure(config('polanco.admin_email'));
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
