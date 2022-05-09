<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateProduct()
    {
        $userData = array(
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'test123'
        );
        $response = $this->post('/api/auth/signup', $userData);

        $response->assertStatus(201);
    }
}
