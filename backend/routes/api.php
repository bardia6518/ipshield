<?php

use App\Infrastructure\Monitoring\SystemHealthProbe;
use Illuminate\Support\Facades\Route;

$apiVersion = (string) config('ipshield.api_version', 'v1');

Route::prefix($apiVersion)
    ->name("api.{$apiVersion}.")
    ->group(function () use ($apiVersion): void {
        Route::get('/health', function (SystemHealthProbe $probe) use ($apiVersion) {
            $checks = $probe->snapshot();
            $healthy = $probe->coreHealthy($checks);

            return response()->json([
                'success' => $healthy,
                'data' => [
                    'status' => $healthy ? 'ok' : 'degraded',
                    'checks' => $checks,
                ],
                'message' => null,
                'meta' => ['api_version' => $apiVersion],
            ], $healthy ? 200 : 503)
                ->header('X-API-Version', $apiVersion);
        })->name('health');
    });
