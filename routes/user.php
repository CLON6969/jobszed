<?php
// public controllers
use App\Http\Controllers\{
    DashboardController,
    User\Account\ProfileAccountController
};

// User-only routes...
Route::middleware(['auth', 'role:3'])->prefix('user')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    
    // Loading countdown view
    Route::view('/loading_count_down', 'loading_count_down');


});
