<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TestingFoundationTest extends TestCase
{
    public function test_test_suite_uses_postgresql_only(): void
    {
        $this->assertSame('pgsql', DB::connection()->getDriverName());

        $database = DB::selectOne('select current_database() as name');

        $this->assertSame('ipshield_test', $database->name);
    }

    public function test_test_database_is_not_development_database(): void
    {
        $this->assertNotSame('ipshield', (string) config('database.connections.pgsql.database'));
        $this->assertSame('ipshield_test', (string) config('database.connections.pgsql.database'));
    }
}
