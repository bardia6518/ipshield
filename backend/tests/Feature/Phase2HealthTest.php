<?php

namespace Tests\Feature;

use Tests\TestCase;

class Phase2HealthTest extends TestCase
{
    public function test_health_route_uses_phase2_response_shape(): void
    {
        $response = $this->getJson('/api/v1/health');

        $this->assertContains($response->status(), [200, 503]);
        $response->assertJsonStructure([
            'success',
            'data' => ['status', 'checks'],
            'message',
            'meta' => ['api_version'],
        ]);
    }
}
