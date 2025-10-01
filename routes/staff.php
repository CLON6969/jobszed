<?php
// public controllers
use App\Http\Controllers\{
DashboardController


};




 // Staff-only routes...

Route::middleware(['auth', 'role:2'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staff'])->name('dashboard');
    // Staff-only routes...

    Route::view('/loading_count_down', 'loading_count_down');
});

