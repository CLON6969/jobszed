<?php


use Illuminate\Support\Facades\Route;

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
supportController,
AboutController


};


Route::get('/', [HomeController::class, 'index']);

Route::get('/contact', [ContactController::class, 'show'])->name('contact.form');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/support', [supportController::class, 'show'])->name('support.form');
Route::post('/support', [supportController::class, 'submit'])->name('support.submit');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/about', [AboutController::class, 'index'])->name('about.index');



// routes/web.php


// routes/web.php

Route::middleware(['auth', 'ensure.applicant'])->group(function () {
    Route::get('/apply/{slug}', [ApplicationController::class, 'create'])->name('jobs.apply');
    Route::post('/apply/{slug}', [ApplicationController::class, 'store'])->name('jobs.apply.store');
    
});








Route::get('/legal/{slug}', function ($slug) {
    $document = LegalDocument::where('slug', $slug)->with(['sections.listItems'])->firstOrFail();
    return view('legal.show', compact('document'));
})->name('legal.show');

 Route::view('/loading_count_down', 'loading_count_down')->name('loading_count_down');






require __DIR__.'/admin.php';
require __DIR__.'/staff.php';
require __DIR__.'/user.php';
require __DIR__.'/employer.php';
require __DIR__.'/applicant.php';
require __DIR__.'/auth.php';


Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'user.employer.dashboard',
            4 => 'user.applicant.dashboard',
        });
    }

    return view('auth.login');
})->name('login');
    
Route::get('/register', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'user.employer.dashboard',
            4 => 'user.applicant.dashboard',
        });
    }

    return view('auth.register');
})->name('register');

Route::get('/register/employer', function () {
    if (auth()->check()) {
        return redirect()->route(match (auth()->user()->role_id) {
            1 => 'admin.dashboard',
            2 => 'staff.dashboard',
            3 => 'user.employer.dashboard',
            4 => 'user.applicant.dashboard',
        });
    }

    return view('auth.register');
})->name('register');
