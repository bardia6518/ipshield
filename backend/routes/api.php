<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

$apiVersion = (string) config('ipshield.api_version', 'v1');

Route::prefix($apiVersion)
    ->name("api.{$apiVersion}.")
    ->group(function () use ($apiVersion): void {
        Route::get('/health', function () use ($apiVersion) {
            $checks = ['application' => true, 'database' => false, 'redis' => false];

            try {
                DB::select('select 1');
                $checks['database'] = true;
            } catch (Throwable) {}

            try {
                $checks['redis'] = (string) Redis::ping() !== '';
            } catch (Throwable) {}

            $healthy = ! in_array(false, $checks, true);
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
