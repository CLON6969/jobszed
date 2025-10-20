<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\MessageController;
use App\Http\Controllers\Customer\CategoryController;
use App\Http\Controllers\Customer\ProductController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\OrderItemController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Customer\AnalyticsController;
use App\Http\Controllers\Customer\GuestSessionController;
use App\Http\Controllers\Customer\ProfileController;

use App\Http\Controllers\Customer\{
    CustomerDashboardController,
    CustomerOrderController,
    CustomerSavedController,
    CustomerMessageController,
    CustomerScheduleController,
    CustomerAnalyticsController,
    CustomerViewsController
};

use App\Http\Controllers\{
    OnboardingController,
    DashboardController
};

use App\Http\Controllers\Web\OverviewController;

use App\Http\Controllers\User\Customer\UserJobsController;
use App\Http\Controllers\User\Customer\UserApplicationController;

use App\Http\Controllers\User\Customer\{
    CustomerLocationController,
    ExperienceController,
    EducationController,
    CustomerCertificationController,
    VoluntaryDisclosureController,
    CareerDashboardController
};

// -----------------------------
// Customer-only onboarding routes
// -----------------------------
Route::middleware(['auth', 'ensure.Customer'])->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('step1', [OnboardingController::class, 'step1'])->name('step1');
    Route::post('step1', [OnboardingController::class, 'postStep1'])->name('postStep1');
    Route::get('step2', [OnboardingController::class, 'step2'])->name('step2');
    Route::post('step2', [OnboardingController::class, 'postStep2'])->name('postStep2');
    Route::get('step3', [OnboardingController::class, 'step3'])->name('step3');
    Route::post('step3', [OnboardingController::class, 'postStep3'])->name('postStep3');
    Route::get('step4', [OnboardingController::class, 'step4'])->name('step4');
    Route::post('step4', [OnboardingController::class, 'postStep4'])->name('postStep4');
    Route::get('step5', [OnboardingController::class, 'step5'])->name('step5');
    Route::post('step5', [OnboardingController::class, 'postStep5'])->name('postStep5');
    Route::get('review', [OnboardingController::class, 'review'])->name('review');
    Route::post('submit', [OnboardingController::class, 'submit'])->name('submit');
});

// -----------------------------
// Customer dashboard & profile CRUD routes (role:4)
// -----------------------------
Route::middleware(['auth', 'role:4'])->prefix('customer')->name('Customer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'Customer'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down');

    // Customer views
    Route::get('/', [CustomerViewsController::class, 'index'])->name('home.index');
    Route::get('/product/{id}', [CustomerViewsController::class, 'show'])->name('home.show');
    Route::post('/product/{id}/save', [CustomerViewsController::class, 'save'])->name('home.save');
    Route::post('/product/{id}/review', [CustomerViewsController::class, 'review'])->name('home.review');
    Route::post('/product/{id}/message', [CustomerViewsController::class, 'message'])->name('home.message');

    // -----------------------------
    // Customer profile CRUD
    // -----------------------------
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // -----------------------------
    // Orders
    // -----------------------------
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [CustomerOrderController::class, 'show'])->name('show');
    });

    // -----------------------------
    // Saved Products
    // -----------------------------
    Route::prefix('saved')->name('saved.')->group(function () {
        Route::get('/', [CustomerSavedController::class, 'index'])->name('index');
        Route::post('/{product}', [CustomerSavedController::class, 'store'])->name('store');
        Route::delete('/{product}', [CustomerSavedController::class, 'destroy'])->name('destroy');
    });

    // -----------------------------
    // Messages (In-App Chat)
    // -----------------------------
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{seller}/{product?}', [MessageController::class, 'show'])->name('show');
        Route::post('/{seller}/{product?}', [MessageController::class, 'send'])->name('send');
        Route::get('/{id}/edit', [MessageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MessageController::class, 'update'])->name('update');
        Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/download', [MessageController::class, 'download'])->name('download');
    });

    // -----------------------------
    // Schedule
    // -----------------------------
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [CustomerScheduleController::class, 'index'])->name('index');
        Route::post('/{order}', [CustomerScheduleController::class, 'store'])->name('store');
        Route::delete('/{order}', [CustomerScheduleController::class, 'destroy'])->name('destroy');
    });

    // -----------------------------
    // Analytics
    // -----------------------------
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [CustomerAnalyticsController::class, 'index'])->name('index');
        Route::get('/orders', [CustomerAnalyticsController::class, 'orders'])->name('orders');
        Route::get('/spending', [CustomerAnalyticsController::class, 'spending'])->name('spending');
        Route::get('/activity', [CustomerAnalyticsController::class, 'activity'])->name('activity');
    });
});
