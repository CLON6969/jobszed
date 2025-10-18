<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    CategoryController,
    SellerController,
    GuestSessionController
};

// -----------------------------
// Public / Guest Routes
// -----------------------------
Route::prefix('public')->group(function () {

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);

    // Seller Public Profile
    Route::get('/sellers/{seller}', [SellerController::class, 'show']);

    // Guest Session Tracking (Hybrid model)
    Route::apiResource('guest-sessions', GuestSessionController::class)->only(['store', 'update']);
});
