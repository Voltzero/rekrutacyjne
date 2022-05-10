<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * Testing product create
     *
     * @return void
     */
    public function test_create_product(): void
    {
        $productData = array(
            'name' => 'Test Product',
            'quantity' => 100,
            'price' => '99,99',
            'code' => '$!#$!SADQWE'
        );
        $token = User::first()->createToken('Bearer')->plainTextToken;

        $response = $this->post('/api/product', $productData, [
            'HTTP_AUTHORIZATION' => "Bearer ${token}"
        ]);

        $response->assertStatus(201);
    }

    public function test_update_product(): void
    {
        $token = User::first()->createToken('Bearer')->plainTextToken;

        Product::factory()->count(1)->create();

        $response = $this->put("/api/product/1", [
            'name' => 'changed name',
            'quantity' => 122,
            'price' => "12",
            'code' => '123123ADS'
        ], [
            'HTTP_AUTHORIZATION' => "Bearer ${token}"
        ]);

        $response->assertStatus(200);
    }


    public function test_show_product(): void
    {
        Product::factory()->count(1)->create();

        $response = $this->get("/api/product/1");

        $response->assertStatus(200);
    }

    public function test_show_all_products(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->get("/api/product");

        $response->assertStatus(200);
    }

    public function test_delete_product(): void
    {
        $token = User::first()->createToken('Bearer')->plainTextToken;

        Product::factory()->count(1)->create();

        $response = $this->delete("/api/product/1", [], [
            'HTTP_AUTHORIZATION' => "Bearer ${token}"
        ]);

        $response->assertStatus(200);
    }
}
