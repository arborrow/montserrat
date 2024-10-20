<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('mailgun:get')->hourlyAt(55)
    ->between('05:30', '18:30')
    ->emailOutputOnFailure(config('polanco.admin_email'));
Schedule::command('import:stripe_payouts')->dailyAt('08:00')->emailOutputOnFailure(config('polanco.admin_email'));
Schedule::command('email:birthdays')->dailyAt('06:00')->emailOutputOnFailure(config('polanco.admin_email'));
Schedule::command('email:confirmations')->dailyAt('07:00')->emailOutputOnFailure(config('polanco.admin_email'));
