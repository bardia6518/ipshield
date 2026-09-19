<?php

namespace App\Providers;

use App\Application\Contracts\TransactionManager;
use App\Infrastructure\Persistence\LaravelTransactionManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TransactionManager::class, LaravelTransactionManager::class);
    }

    public function boot(): void
    {
        //
    }
}
