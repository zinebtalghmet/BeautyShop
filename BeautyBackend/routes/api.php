<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\SlideController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);
    Route::get('/categories/{slug}/products', [CategoryController::class, 'products']);

    // Public auth routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

    // Public content routes
    Route::get('/settings', [SettingController::class, 'index']);
    Route::get('/slides', [SlideController::class, 'index']);
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::post('/contacts', [ContactController::class, 'store']);

    // Cart routes (auth or session)
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::put('/cart/{cartItem}', [CartController::class, 'updateQuantity']);
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove']);
    Route::delete('/cart', [CartController::class, 'clear']);

    // Authenticated user routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/me', [AuthController::class, 'updateProfile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::post('/orders', [OrderController::class, 'store']);
    });
});
