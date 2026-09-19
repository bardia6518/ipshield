<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('ipshield:scheduler-probe', function () {
    $ranAt = now()->utc()->toISOString();

    Cache::put('ipshield:scheduler:probe:last_run', $ranAt, 300);

    Log::info('scheduler.probe', [
        'ran_at' => $ranAt,
        'timezone' => 'UTC',
    ]);

    $this->info('IPSHIELD_SCHEDULER_PROBE=PASS');
})->purpose('Validate the IPShield scheduler foundation.');

Schedule::command('ipshield:scheduler-probe')
    ->everyMinute()
    ->name('ipshield:scheduler-probe')
    ->withoutOverlapping(5)
    ->onOneServer();
