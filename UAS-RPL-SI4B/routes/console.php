<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Menjalankan command kustom kita setiap hari jam 08.00 pagi
Schedule::command('app:send-pickup-reminders')->dailyAt('08:00');
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
