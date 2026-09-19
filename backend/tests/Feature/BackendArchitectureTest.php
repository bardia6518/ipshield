<?php

namespace Tests\Feature;

use App\Application\Contracts\TransactionManager;
use App\Infrastructure\Persistence\LaravelTransactionManager;
use Tests\TestCase;

class BackendArchitectureTest extends TestCase
{
    public function test_transaction_manager_contract_is_bound_to_infrastructure(): void
    {
        $resolved = $this->app->make(TransactionManager::class);

        $this->assertInstanceOf(LaravelTransactionManager::class, $resolved);
    }
}
