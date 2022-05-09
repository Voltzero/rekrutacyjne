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
            'price' => '99,99'
        );
        $token = User::first()->createToken('Bearer')->plainTextToken;

        $response = $this->post('/api/product', $productData, [
            'HTTP_AUTHORIZATION' => "Bearer ${token}"
        ]);

        $response->assertStatus(201);
    }

//    public function test_update_product(): void
//    {
//        $productData = array(
//            'name' => 'Update Product',
//            'quantity' => 100,
//            'price' => '99,99'
//        );
//        $token = User::first()->createToken('Bearer')->plainTextToken;
//
//        $productResponse = $this->post('/api/product', $productData, [
//            'HTTP_AUTHORIZATION' => "Bearer ${token}"
//        ]);
//        $productId = $productResponse->id;
//        $response = $this->put("/api/product/${$productId}", [
//            'name' => 'changed name',
//            'quantity' => 122,
//            'price' => 12
//        ], [
//            'HTTP_AUTHORIZATION' => "Bearer ${token}"
//        ]);
//
//        $response->assertStatus(200);
//    }
}
