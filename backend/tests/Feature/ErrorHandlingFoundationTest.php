<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use RuntimeException;
use Tests\TestCase;

class ErrorHandlingFoundationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('api')->post('/api/v1/_test-validation', function (Request $request) {
            $request->validate(['name' => ['required', 'string']]);

            return response()->json(['ok' => true]);
        });

        Route::middleware('api')->get('/api/v1/_test-internal-error', function () {
            throw new RuntimeException('sensitive-internal-marker');
        });
    }

    public function test_validation_errors_use_standard_api_contract(): void
    {
        $response = $this->postJson('/api/v1/_test-validation', []);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $response->assertJsonPath('error.code', 'VALIDATION_ERROR');
        $response->assertJsonStructure(['errors' => ['name']]);
    }

    public function test_not_found_errors_use_standard_api_contract(): void
    {
        $response = $this->getJson('/api/v1/does-not-exist');

        $response->assertNotFound();
        $response->assertJsonPath('error.code', 'NOT_FOUND');
    }

    public function test_internal_errors_do_not_leak_exception_details(): void
    {
        $response = $this->getJson('/api/v1/_test-internal-error');

        $response->assertStatus(500);
        $response->assertJsonPath('error.code', 'INTERNAL_ERROR');
        $response->assertJsonPath('message', 'An internal error occurred.');
        $this->assertStringNotContainsString('sensitive-internal-marker', $response->getContent());
    }
}
