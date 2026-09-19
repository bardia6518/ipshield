<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

class Phase2ProbeJob implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public int $tries = 3;
    public int $timeout = 30;
    public bool $failOnTimeout = true;
    public int $uniqueFor = 300;

    public function __construct(
        public string $probeId = 'default',
        public bool $shouldFail = false,
    ) {}

    public function uniqueId(): string
    {
        return 'phase2-probe:'.$this->probeId;
    }

    public function backoff(): array
    {
        return [1, 2, 5];
    }

    public function handle(): void
    {
        $marker = 'phase2:queue_probe:'.$this->probeId;

        if (Cache::has($marker)) {
            return;
        }

        if ($this->shouldFail) {
            throw new RuntimeException('Phase 2 failed-job probe.');
        }

        Cache::put($marker, now()->toISOString(), 600);
    }
}
