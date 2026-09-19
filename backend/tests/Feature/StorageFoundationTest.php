<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageFoundationTest extends TestCase
{
    public function test_evidence_disk_is_private_and_outside_public_storage(): void
    {
        $root = (string) config('filesystems.disks.evidence.root');

        $this->assertStringContainsString('storage', $root);
        $this->assertStringContainsString('evidence', $root);
        $this->assertStringNotContainsString('public', strtolower($root));
        $this->assertSame('private', config('filesystems.disks.evidence.visibility'));
    }

    public function test_evidence_disk_supports_private_file_operations(): void
    {
        Storage::fake('evidence');

        Storage::disk('evidence')->put('phase2/probe.txt', 'fixture-only');

        Storage::disk('evidence')->assertExists('phase2/probe.txt');
        $this->assertSame('fixture-only', Storage::disk('evidence')->get('phase2/probe.txt'));
    }
}
