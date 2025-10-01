<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EmployerProfileController,
    DashboardController,
};
use App\Http\Controllers\User\Employer\EmployerOverviewController;

use App\Http\Controllers\User\Applicant\UserJobsController; 
use App\Http\Controllers\User\Applicant\UserApplicationController;

use App\Http\Controllers\User\Employer\{
    EmployerWebJobApplicationController,
    EmployerWebJobPostController,
    EmployerApplicationManagementController,
};

// -----------------------------
// employer & profile CRUD routes (role:3)
// -------------------------
Route::middleware(['auth', 'role:3'])->prefix('user/employer')->name('user.employer.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'employer'])->name('dashboard');
    Route::view('/loading_count_down', 'loading_count_down');

    // --- Employer Dashboard Overview ---
    Route::get('/overview', [EmployerOverviewController::class, 'index'])->name('dashboard.overview');

    // employer profile CRUD (user table)
    Route::prefix('profile-account')->name('profile-account.')->group(function () {
        Route::get('/', [EmployerProfileController::class, 'edit'])->name('index'); // show form
        Route::put('/update', [EmployerProfileController::class, 'update'])->name('update'); // update
        Route::delete('/delete', [EmployerProfileController::class, 'destroy'])->name('destroy'); // delete
    });

    // --- Applications Management ---
    Route::prefix('applications')->name('web.applications.')->group(function () {
        Route::get('/', [EmployerWebJobApplicationController::class, 'index'])->name('index');
        Route::get('/{job}/applicants', [EmployerWebJobApplicationController::class, 'applicants'])->name('applicants');
        Route::get('/applicant/{application}', [EmployerWebJobApplicationController::class, 'show'])->name('show');
        Route::put('/applicant/{application}/update', [EmployerWebJobApplicationController::class, 'updateStatus'])->name('update');
    });

    // --- Email Applications Management (CRUD + Email Templates) ---
    Route::prefix('web/Email_application_management')->name('web.Email_application_management.')->group(function () {

        // Main index page
        Route::get('/', [EmployerApplicationManagementController::class, 'index'])->name('index');

        // Store or update Job-level details
        Route::post('/{jobId}/{type}', [EmployerApplicationManagementController::class, 'storeDetail'])->name('storeDetail');

        // Update Email Template
        Route::put('/email-template/{id}', [EmployerApplicationManagementController::class, 'updateEmailTemplate'])->name('updateEmailTemplate');
    });

    // --- Job Post Management ---
    Route::prefix('job')->name('web.job.')->group(function () {
        Route::get('/userview', [EmployerWebJobPostController::class, 'userview'])->name('userview');
        Route::get('/', [EmployerWebJobPostController::class, 'index'])->name('index');
        Route::get('/create', [EmployerWebJobPostController::class, 'create'])->name('create');
        Route::post('/', [EmployerWebJobPostController::class, 'store'])->name('store');
        Route::get('/{job}/edit', [EmployerWebJobPostController::class, 'edit'])->name('edit');
        Route::put('/{job}', [EmployerWebJobPostController::class, 'update'])->name('update');
        Route::get('/job/all-posts', [EmployerWebJobPostController::class, 'allPosts'])->name('allPosts');
        Route::delete('/{job}', [EmployerWebJobPostController::class, 'destroy'])->name('destroy');
    });
});
