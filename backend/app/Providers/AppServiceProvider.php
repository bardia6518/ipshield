<?php

namespace App\Providers;

use App\Application\Contracts\TransactionManager;
use App\Infrastructure\Persistence\LaravelTransactionManager;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TransactionManager::class, LaravelTransactionManager::class);
    }

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request): Limit {
            $key = $request->user()?->getAuthIdentifier() ?? $request->ip();

            return Limit::perMinute(60)->by((string) $key);
        });
    }
}
