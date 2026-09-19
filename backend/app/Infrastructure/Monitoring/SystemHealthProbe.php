<?php

namespace App\Infrastructure\Monitoring;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Throwable;

class SystemHealthProbe
{
    public function snapshot(): array
    {
        $database = $this->databaseStatus();
        $redis = $this->redisStatus();

        return [
            'application' => ['status' => 'ok'],
            'database' => $database,
            'redis' => $redis,
            'queue' => $this->queueStatus($database['status'] === 'ok'),
            'scheduler' => $this->schedulerStatus($redis['status'] === 'ok'),
        ];
    }

    public function coreHealthy(array $snapshot): bool
    {
        return $snapshot['application']['status'] === 'ok'
            && $snapshot['database']['status'] === 'ok'
            && $snapshot['redis']['status'] === 'ok';
    }

    private function databaseStatus(): array
    {
        try {
            DB::select('select 1');

            return ['status' => 'ok'];
        } catch (Throwable) {
            return ['status' => 'down'];
        }
    }

    private function redisStatus(): array
    {
        try {
            Redis::ping();

            return ['status' => 'ok'];
        } catch (Throwable) {
            return ['status' => 'down'];
        }
    }

    private function queueStatus(bool $databaseAvailable): array
    {
        if (! $databaseAvailable) {
            return ['status' => 'unknown', 'failed_jobs' => null];
        }

        try {
            $failed = (int) DB::table('failed_jobs')->count();

            return [
                'status' => $failed > 0 ? 'attention' : 'ok',
                'failed_jobs' => $failed,
            ];
        } catch (Throwable) {
            return ['status' => 'unknown', 'failed_jobs' => null];
        }
    }

    private function schedulerStatus(bool $redisAvailable): array
    {
        if (! $redisAvailable) {
            return ['status' => 'unknown', 'last_run' => null];
        }

        try {
            $lastRun = Cache::get('ipshield:scheduler:probe:last_run');

            return [
                'status' => $lastRun ? 'ok' : 'unknown',
                'last_run' => $lastRun,
            ];
        } catch (Throwable) {
            return ['status' => 'unknown', 'last_run' => null];
        }
    }
}
