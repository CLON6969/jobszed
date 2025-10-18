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




use App\Http\Controllers\{
    OnboardingController,
    DashboardController,
    
};



use App\Http\Controllers\Web\OverviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\Customer\UserJobsController; // <-- Added correct namespace
use App\Http\Controllers\User\Customer\UserApplicationController;

use App\Http\Controllers\User\Customer\{
    CustomerProfileController,
    CustomerLocationController,
    ExperienceController,
    EducationController,
    CustomerCertificationController,
    VoluntaryDisclosureController,
    CareerDashboardController,
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
Route::middleware(['auth', 'role:4'])->prefix('user/Customer')->name('user.Customer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'Customer'])->name('dashboard');
   
    Route::view('/loading_count_down', 'loading_count_down');



            // Dashboard
        Route::get('/dashboard', [AnalyticsController::class, 'index'])->name('dashboard');

        // -----------------------------
        // Analytics
        // -----------------------------
        Route::prefix('analytics')->name('analytics.')->group(function () {
            Route::get('/', [AnalyticsController::class, 'index'])->name('index');
            Route::get('/orders', [AnalyticsController::class, 'orders'])->name('orders');
            Route::get('/spending', [AnalyticsController::class, 'spending'])->name('spending');
            Route::get('/activity', [AnalyticsController::class, 'activity'])->name('activity');
        });

        // -----------------------------
        // Messages (to Sellers or Admin)
        // -----------------------------
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::get('/{id}', [MessageController::class, 'show'])->name('show');
            Route::post('/send', [MessageController::class, 'store'])->name('store');
            Route::put('/{id}/update', [MessageController::class, 'update'])->name('update'); // edit message
            Route::delete('/{id}/delete', [MessageController::class, 'destroy'])->name('destroy');
        });

        // -----------------------------
        // Product Browsing & Interaction
        // -----------------------------
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        });

        // -----------------------------
        // Orders
        // -----------------------------
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('show');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::put('/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');
            Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        });

        // -----------------------------
        // Order Items
        // -----------------------------
        Route::prefix('order-items')->name('order-items.')->group(function () {
            Route::get('/', [OrderItemController::class, 'index'])->name('index');
            Route::get('/{id}', [OrderItemController::class, 'show'])->name('show');
        });

        // -----------------------------
        // Reviews (with edit tracking)
        // -----------------------------
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::post('/', [ReviewController::class, 'store'])->name('store');
            Route::put('/{id}/update', [ReviewController::class, 'update'])->name('update'); // mark as "edited"
            Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        });

        // -----------------------------
        // Guest Sessions
        // -----------------------------
        Route::prefix('guest-sessions')->name('guest-sessions.')->group(function () {
            Route::get('/', [GuestSessionController::class, 'index'])->name('index');
            Route::get('/{id}', [GuestSessionController::class, 'show'])->name('show');
        });

    });

// -----------------------------
// Public (Guest) Customer Routes
// -----------------------------
// Allow non-logged-in users to send inquiries or reviews
Route::prefix('guest')->name('guest.')->group(function () {

    // -----------------------------
    // Inquiries via WhatsApp or Email (no auth)
    // -----------------------------
    Route::prefix('inquiry')->name('inquiry.')->group(function () {
        Route::post('/send-whatsapp', [MessageController::class, 'sendViaWhatsApp'])->name('sendWhatsApp');
        Route::post('/send-email', [MessageController::class, 'sendViaEmail'])->name('sendEmail');
    });

    // -----------------------------
    // Guest Product Reviews
    // -----------------------------
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::post('/{productId}', [ReviewController::class, 'guestStore'])->name('store');
    });



    // Customer profile CRUD (user table)
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('index'); // show form
        Route::put('/update', [ProfileController::class, 'update'])->name('update'); // update
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('destroy'); // delete
    });






});


