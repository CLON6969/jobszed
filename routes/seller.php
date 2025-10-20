<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Seller\AnalyticsController;
use App\Http\Controllers\Seller\MessageController;
use App\Http\Controllers\Seller\CategoryController;
use App\Http\Controllers\Seller\ProductFullController;
use App\Http\Controllers\Seller\ProductVariationController;
use App\Http\Controllers\Seller\ProductMediaController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\OrderItemController;
use App\Http\Controllers\Seller\ReviewController;
use App\Http\Controllers\Seller\GuestSessionController;
use App\Http\Controllers\Seller\ProductCreationController;


use App\Http\Controllers\{
    SellerProfileController,
    DashboardController,
    
};



use App\Http\Controllers\User\Seller\{
  
    SellerWebJobPostController,
    SellerApplicationManagementController,
};

// -----------------------------
// Seller & profile CRUD routes (role:3)
// -------------------------
Route::middleware(['auth', 'role:3'])->prefix('Seller')->name('Seller.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'Seller'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down');

   


        // -----------------------------
        // Analytics Routes
        // -----------------------------
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            Route::get('/sales', [AnalyticsController::class, 'sales'])->name('sales');
            Route::get('/products', [AnalyticsController::class, 'products'])->name('products');
            Route::get('/customers', [AnalyticsController::class, 'customers'])->name('customers');
            Route::get('/orders', [AnalyticsController::class, 'orders'])->name('orders');
            Route::get('/show', [AnalyticsController::class, 'orders'])->name('show');
        });

        // -----------------------------
        // Messages (Seller-Customer)
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{Customer}/{product?}', [MessageController::class, 'show'])->name('show');
        Route::post('/{Customer}/{product?}', [MessageController::class, 'send'])->name('send');
        Route::put('/{id}', [MessageController::class, 'update'])->name('update');
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
        Route::get('/download/{id}', [MessageController::class, 'download'])->name('download');
    });
        // -----------------------------
        // Categories
        // -----------------------------
// -----------------------------
// Categories
// -----------------------------
Route::prefix('categories')->name('categories.')->group(function () {
    // List all categories
    Route::get('/', [CategoryController::class, 'index'])->name('index');

    // Create form + store
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');

    // Show a single category (you were missing this)
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');

    // Edit + update
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');

    // Delete
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
});



        // -----------------------------
        // Products & Product Variations
        // -----------------------------

Route::prefix('products')->name('products.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProductFullController::class, 'index'])->name('index');
    Route::get('/create', [ProductFullController::class, 'create'])->name('create');
    Route::post('/', [ProductFullController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductFullController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductFullController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductFullController::class, 'destroy'])->name('destroy');

       // Show single product details
    Route::get('/{id}', [ProductFullController::class, 'show'])->name('show');

    // Single media deletion (AJAX)
    Route::delete('/media/{id}', [ProductFullController::class, 'deleteMedia'])->name('media.delete');

    // Full listing creation routes
    Route::get('/create-full', [ProductFullController::class, 'create'])->name('create-full');
    Route::post('/create-full', [ProductFullController::class, 'store'])->name('storeFull');
     Route::post('/{id}/quick-update', [ProductFullController::class, 'quickUpdate'])->name('quick-update');
});





Route::prefix('product-variations')->name('product-variations.')->middleware(['auth'])->group(function () {
    Route::get('/', [ProductVariationController::class, 'index'])->name('index');
    Route::get('/create', [ProductVariationController::class, 'create'])->name('create');
    Route::post('/', [ProductVariationController::class, 'store'])->name('store');
    Route::get('/{id}', [ProductVariationController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProductVariationController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductVariationController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductVariationController::class, 'destroy'])->name('destroy');
});


        // -----------------------------
        // Product Media
        // -----------------------------






Route::prefix('product-media')->name('product-media.')->group(function () {
    Route::get('/', [ProductMediaController::class, 'index'])->name('index');
    Route::get('/create', [ProductMediaController::class, 'create'])->name('create');
    Route::post('/', [ProductMediaController::class, 'store'])->name('store');
    Route::get('/{id}', [ProductMediaController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProductMediaController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductMediaController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductMediaController::class, 'destroy'])->name('destroy');
});









        // -----------------------------
        // Orders & Order Items
        // -----------------------------
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::put('/{id}/update-status', [OrderController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('order-items')->name('order-items.')->group(function () {
            Route::get('/', [OrderItemController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderItemController::class, 'show'])->name('show');
            Route::post('/', [OrderItemController::class, 'store'])->name('store');
            Route::put('/{id}', [OrderItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [OrderItemController::class, 'destroy'])->name('destroy');
        });

        // -----------------------------
        // Reviews
        // -----------------------------
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        });

        // -----------------------------
        // Guest Sessions
        // -----------------------------
        Route::prefix('guest-sessions')->name('guest-sessions.')->group(function () {
            Route::get('/', [GuestSessionController::class, 'index'])->name('index');
            Route::get('/{id}', [GuestSessionController::class, 'show'])->name('show');
            Route::delete('/{id}', [GuestSessionController::class, 'destroy'])->name('destroy');
        });


    // Seller profile CRUD (user table)
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [SellerProfileController::class, 'edit'])->name('index'); // show form
        Route::put('/update', [SellerProfileController::class, 'update'])->name('update'); // update
        Route::delete('/delete', [SellerProfileController::class, 'destroy'])->name('destroy'); // delete
    });




});
