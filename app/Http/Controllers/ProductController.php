<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private const CREATE_VALIDATION_RULES = [
        'name' => 'required|string',
        'quantity' => 'required|integer',
        'price' => 'required|string',
    ];

    public function createProduct(Request $request, Product $product): JsonResponse
    {
        $newProduct = $product->create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        $newProduct->save();

        return response()->json(
            [
                'message' => 'Successfully created product!',
                'product' => $newProduct,
            ],
            201
        );
    }
}
