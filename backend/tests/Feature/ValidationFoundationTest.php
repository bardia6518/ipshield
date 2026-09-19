<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ValidationFoundationTest extends TestCase
{
    public function test_allow_list_validation_drops_unvalidated_fields(): void
    {
        $validator = Validator::make([
            'name' => 'probe',
            'unexpected' => 'must-not-pass-through',
        ], [
            'name' => ['required', 'string', 'max:50'],
        ]);

        $this->assertSame(['name' => 'probe'], $validator->validated());
    }

    public function test_invalid_payload_is_rejected(): void
    {
        $validator = Validator::make(['name' => str_repeat('x', 51)], [
            'name' => ['required', 'string', 'max:50'],
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->toArray());
    }
}
