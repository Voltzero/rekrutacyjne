<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * Test user signup
     *
     * @return void
     */
    public function test_signup(): void
    {
        $userData = array(
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'test123'
        );
        $response = $this->post('/api/auth/signup', $userData);

        $response->assertStatus(201);
    }

    /**
     * Test login of seeded user
     *
     * @return void
     */
    public function test_login(): void
    {
        $userData = array(
            'email' => 'user@user.com',
            'password' => 'password'
        );
        $response = $this->post('/api/auth/login', $userData);

        $response->assertStatus(200);
    }
}
