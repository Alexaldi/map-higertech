<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sinkronisasi otomatis data stasiun dan telemetri Pos Monitoring setiap 15 menit
Illuminate\Support\Facades\Schedule::command('stations:sync')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->runInBackground();

