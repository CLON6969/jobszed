<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\GuestMessageController;
use App\Http\Controllers\Guest\GuestReviewController;

// Models baing used 
use App\Models\{
    LegalDocument,
};

// public controllers
use App\Http\Controllers\{
HomeController,
JobController,
ApplicationController,
ContactController,
SupportController,
AboutController


};




// ----------------------
// Public Routes
// ----------------------
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('home.show');
Route::post('/product/{id}/save', [HomeController::class, 'save'])->name('home.save');
Route::post('/product/{id}/review', [HomeController::class, 'review'])->name('home.review');
Route::post('/product/{id}/message', [HomeController::class, 'message'])->name('home.message');



Route::get('/contact', [ContactController::class, 'show'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/support', [SupportController::class, 'show'])->name('support.form');
Route::post('/support', [SupportController::class, 'submit'])->name('support.submit');



Route::get('/about', [AboutController::class, 'index'])->name('about.index');

Route::get('/legal/{slug}', function ($slug) {
    $document = LegalDocument::where('slug', $slug)->with(['sections.listItems'])->firstOrFail();
    return view('legal.show', compact('document'));
})->name('legal.show');

Route::view('/loading_count_down', 'loading_count_down')->name('loading_count_down');

// ----------------------
// Auth-Protected Product Actions
// ----------------------
Route::prefix('products')->name('products.')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::post('/{product}/save', [HomeController::class, 'save'])->name('home.save');
        Route::post('/{product}/review', [HomeController::class, 'review'])->name('review');
        Route::post('/{product}/message', [HomeController::class, 'message'])->name('message');
    });
});

// ----------------------
// Guest Enquiries
// ----------------------
Route::prefix('guest')->name('guest.')->group(function () {
    Route::prefix('inquiry')->name('inquiry.')->group(function () {
        Route::post('/send-whatsapp', [GuestMessageController::class, 'sendViaWhatsApp'])->name('sendWhatsApp');
        Route::post('/send-email', [GuestMessageController::class, 'sendViaEmail'])->name('sendEmail');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::post('/{productId}', [GuestReviewController::class, 'guestStore'])->name('store');
    });
});





Route::get('/legal/{slug}', function ($slug) {
    $document = LegalDocument::where('slug', $slug)->with(['sections.listItems'])->firstOrFail();
    return view('legal.show', compact('document'));
})->name('legal.show');

 Route::view('/loading_count_down', 'loading_count_down')->name('loading_count_down');






require __DIR__.'/admin.php';
require __DIR__.'/staff.php';
require __DIR__.'/user.php';
require __DIR__.'/seller.php';
require __DIR__.'/Customer.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';


Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'Seller.dashboard',
            4 => 'Customer.dashboard',
        });
    }

    return view('auth.login');
})->name('login');
    
Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'Seller.dashboard',
            4 => 'Customer.dashboard',
        });
    }

    return view('auth.register');
})->name('register');

