<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('auth')->group(
    function () {
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('login', [AuthController::class, 'login']);
    }
);
Route::prefix('product')->group(
    function () {
        Route::get('{product}', [ProductController::class, 'showProduct']);
        Route::get('', [ProductController::class, 'showAllProducts']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('', [ProductController::class, 'createProduct']);
            Route::post('{product}/update', [ProductController::class, 'updateProduct']);
            Route::delete('{product}', [ProductController::class, 'deleteProduct']);
        });
    }
);
