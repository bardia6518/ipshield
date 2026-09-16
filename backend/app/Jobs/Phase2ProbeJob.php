<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class Phase2ProbeJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 30;

    public function handle(): void
    {
        Cache::put('ipshield:phase2:queue_probe', now()->toISOString(), 300);
    }
}
