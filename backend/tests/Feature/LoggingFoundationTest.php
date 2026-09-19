<?php

namespace Tests\Feature;

use App\Support\Logging\LogContextSanitizer;
use Tests\TestCase;

class LoggingFoundationTest extends TestCase
{
    public function test_log_channels_are_separated(): void
    {
        $system = config('logging.channels.system.path');
        $security = config('logging.channels.security.path');
        $audit = config('logging.channels.audit.path');

        $this->assertNotSame($system, $security);
        $this->assertNotSame($system, $audit);
        $this->assertNotSame($security, $audit);
    }

    public function test_sensitive_context_is_redacted_recursively(): void
    {
        $sanitized = app(LogContextSanitizer::class)->sanitize([
            'user_id' => 1,
            'token' => 'secret-token',
            'nested' => ['password' => 'secret-password', 'safe' => 'ok'],
        ]);

        $this->assertSame('[REDACTED]', $sanitized['token']);
        $this->assertSame('[REDACTED]', $sanitized['nested']['password']);
        $this->assertSame('ok', $sanitized['nested']['safe']);
    }
}
