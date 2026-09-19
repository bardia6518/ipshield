<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\Phase2FixtureSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeedFixtureFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_phase2_fixture_is_synthetic_and_idempotent(): void
    {
        $this->seed(Phase2FixtureSeeder::class);
        $this->seed(Phase2FixtureSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => 'fixture@example.test',
            'name' => 'IPShield Fixture User',
        ]);

        $this->assertStringEndsWith('.test', User::query()->firstOrFail()->email);
    }
}
