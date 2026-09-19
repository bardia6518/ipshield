<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Phase2FixtureSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'fixture@example.test'],
            [
                'name' => 'IPShield Fixture User',
                'password' => Hash::make('phase2-fixture-only'),
                'email_verified_at' => now(),
            ],
        );
    }
}
