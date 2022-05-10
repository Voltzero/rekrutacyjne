<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    private const PRODUCT_VALIDATION_RULES = [
        'name' => 'required|string',
        'quantity' => 'required|integer',
        'price' => 'required|string',
    ];

    private const PRODUCT_VALIDATION_MESSAGES = [
        'name.required' => 'Please provide name',
        'quantity.required' => 'Please provide quantity',
        'price.required' => 'Please provide price',
    ];

    public function createProduct(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            self::PRODUCT_VALIDATION_RULES,
            self::PRODUCT_VALIDATION_MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $newProduct = $product->create($validator->validated());

        $newProduct->save();

        return response()->json(
            [
                'message' => 'Successfully created product!',
                'product' => $newProduct,
            ],
            201
        );
    }

    public function updateProduct(Request $request, Product $product): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            self::PRODUCT_VALIDATION_RULES,
            self::PRODUCT_VALIDATION_MESSAGES);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors()
            ], 400);
        }

        $product->update($validator->validated());

        return response()->json($product);
    }

    public function deleteProduct(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function showProduct(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    public function showAllProducts(): Paginator
    {
        return Product::query()->simplePaginate(10);
    }
}
