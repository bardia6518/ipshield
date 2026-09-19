<?php

namespace Tests\Feature;

use Tests\TestCase;

class ObservabilityFoundationTest extends TestCase
{
    public function test_health_endpoint_exposes_independent_components(): void
    {
        $response = $this->getJson('/api/v1/health');

        $this->assertContains($response->status(), [200, 503]);
        $response->assertJsonStructure([
            'data' => [
                'checks' => [
                    'application' => ['status'],
                    'database' => ['status'],
                    'redis' => ['status'],
                    'queue' => ['status', 'failed_jobs'],
                    'scheduler' => ['status', 'last_run'],
                ],
            ],
        ]);
    }
}
