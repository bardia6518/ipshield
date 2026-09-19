<?php

namespace Tests\Feature;

use Tests\TestCase;

class Phase2HealthTest extends TestCase
{
    public function test_health_route_uses_versioned_api_contract(): void
    {
        $response = $this->getJson('/api/v1/health');

        $this->assertContains($response->status(), [200, 503]);
        $response->assertHeader('X-API-Version', 'v1');
        $response->assertJsonPath('meta.api_version', 'v1');
        $response->assertJsonStructure([
            'success',
            'data' => ['status', 'checks'],
            'message',
            'meta' => ['api_version'],
        ]);
    }

    public function test_unversioned_health_route_is_not_exposed(): void
    {
        $this->getJson('/api/health')->assertNotFound();
    }
}
