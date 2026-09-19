<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Sanctum\HasApiTokens;
use Tests\TestCase;

class SecurityBaselineTest extends TestCase
{
    public function test_api_responses_include_security_headers(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_api_rate_limiter_is_registered(): void
    {
        $this->assertNotNull(RateLimiter::limiter('api'));
    }

    public function test_user_model_has_sanctum_api_tokens(): void
    {
        $traits = class_uses_recursive(User::class);

        $this->assertArrayHasKey(HasApiTokens::class, $traits);
    }
}
