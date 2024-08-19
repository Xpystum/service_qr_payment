<?php

namespace Tests\Feature\API\Controllers\Password;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_change_password(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
