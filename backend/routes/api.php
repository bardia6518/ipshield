<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::get('/health', function () {
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
            'data' => ['status' => $healthy ? 'ok' : 'degraded', 'checks' => $checks],
            'message' => null,
            'meta' => ['api_version' => 'v1'],
        ], $healthy ? 200 : 503);
    });
});
