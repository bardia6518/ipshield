<?php

namespace App\Application\Contracts;

interface TransactionManager
{
    public function run(callable $callback): mixed;
}
