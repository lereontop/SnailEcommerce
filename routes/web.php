<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Cart;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Private Routes (Requires Authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // User Routes
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Order Routes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/cart/update', [CartController::class, 'update']);
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove']);

    // Checkout Routes
    Route::post('/checkout', [CheckoutController::class, 'process']);
    Route::post('/payment', [CheckoutController::class, 'payment']);

    // Get cart count
    Route::get('/cart/{userId}/count', function ($userId) {
        $count = Cart::where('user_id', $userId)->count();
        return response()->json(['count' => $count]);
    });

    // Farmer Routes (Only for farmers)
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/farmer/products', [FarmerController::class, 'index']);
        Route::post('/farmer/products', [FarmerController::class, 'store']);
        Route::put('/farmer/products/{id}', [FarmerController::class, 'update']);
        Route::delete('/farmer/products/{id}', [FarmerController::class, 'destroy']);

        Route::get('/farmer/orders', [FarmerController::class, 'orders']);
        Route::patch('/farmer/orders/{id}/status', [FarmerController::class, 'updateOrderStatus']);

        Route::get('/farmer/earnings', [FarmerController::class, 'earnings']);
    });
});

// Fallback route for SPA
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
